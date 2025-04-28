<?php
function query($pdo, $sql, $parameters = []){
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function totalPosts($pdo){
    $query = query($pdo, 'SELECT COUNT(*) FROM posts');
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}   

function getPost($pdo, $id) {
    $sql = 'SELECT * FROM posts WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updatePost($pdo, $postId, $title, $content, $module_id, $imgFromStr) {
    $query = 'UPDATE posts SET title = :title, content = :content, module_id = :module_id, imgFromStr = :imgFromStr WHERE id = :id';
    $parameters = [
        ':id' => $postId,
        ':title' => $title,
        ':content' => $content,
        ':module_id' => $module_id,
        ':imgFromStr' => $imgFromStr
    ];

    query($pdo, $query, $parameters);
}

function deletePost($pdo, $id){
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM posts WHERE id =:id', $parameters);
}

function insertPost($pdo, $title, $content, $user_id, $module_id, $imgFromStr) {
    $query = 'INSERT INTO posts (title, content, created_at, user_id, module_id, imgFromStr) 
              VALUES (:title, :content, NOW(), :user_id, :module_id, :imgFromStr)';

   
    $module_id = !empty($module_id) ? $module_id : NULL;
    $imgFromStr = !empty($imgFromStr) ? $imgFromStr : 'default-image.jpg'; 

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':user_id' => $user_id,
        ':module_id' => $module_id,
        ':imgFromStr' => $imgFromStr
    ]);
}

function allComments($pdo){
    $comments = query($pdo, 'SELECT * FROM comments');
    return $comments->fetchAll();
}

function allModules($pdo){
    $modules = query($pdo, 'SELECT * FROM modules');
    return $modules->fetchAll();
}

function allUsers($pdo){
    $users = query($pdo, 'SELECT * FROM users');
    return $users->fetchAll();
}

function allPosts($pdo) {
    $posts = query($pdo, 'SELECT 
        posts.id, 
        posts.title, 
        posts.content,
        posts.user_id, 
        posts.created_at,
        posts.imgFromStr, 
        modules.module_name, 
        users.username, 
        users.email, 
        users.role,
        COUNT(comments.id) AS comment_count
    FROM posts
    LEFT JOIN modules ON posts.module_id = modules.id
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN comments ON posts.id = comments.post_id
    GROUP BY posts.id
    ORDER BY posts.created_at DESC');
    return $posts->fetchAll();
}

function getPostWithComments($pdo, $post_id) {
    $query = 'SELECT 
        posts.id, 
        posts.title, 
        posts.content, 
        posts.created_at, 
        posts.imgFromStr, 
        modules.module_name, 
        users.username, 
        users.email, 
        users.role,
        (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comment_count
    FROM posts
    INNER JOIN modules ON posts.module_id = modules.id
    INNER JOIN users ON posts.user_id = users.id
    WHERE posts.id = :post_id';

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        return false; 
    }

    // Fetch comments for this post
    $commentQuery = 'SELECT 
        comments.comment_text, 
        comments.created_at, 
        users.username 
    FROM comments
    INNER JOIN users ON comments.user_id = users.id
    WHERE comments.post_id = :post_id
    ORDER BY comments.created_at ASC';

    $stmt = $pdo->prepare($commentQuery);
    $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Add comments and comment count to the post array
    $post['comments'] = $comments;

    return $post;
}

function insertUser($pdo, $username, $email, $password_hash, $role) {
    $sql = "INSERT INTO users (username, email, password_hash, role, created_at) 
            VALUES (:username, :email, :password_hash, :role, NOW())";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password_hash);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function addModule($pdo, $moduleName) {
    $query = 'INSERT INTO modules (module_name) VALUES (:module_name)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':module_name' => $moduleName]);
}

function deleteModule($pdo, $moduleId) {
    // Check if the module is used by any posts
    $query = 'SELECT COUNT(*) AS postCount FROM posts WHERE module_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $moduleId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['postCount'] > 0) {
        // Check if the "Uncategorized" module exists
        $uncategorizedQuery = 'SELECT id FROM modules WHERE module_name = "Uncategorized"';
        $stmt = $pdo->prepare($uncategorizedQuery);
        $stmt->execute();
        $uncategorizedModule = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$uncategorizedModule) {
            // Create the "Uncategorized" module if it doesn't exist
            $createUncategorizedQuery = 'INSERT INTO modules (module_name) VALUES ("Uncategorized")';
            $pdo->exec($createUncategorizedQuery);
            $uncategorizedModuleId = $pdo->lastInsertId();
        } else {
            $uncategorizedModuleId = $uncategorizedModule['id'];
        }

        // Reassign posts to the "Uncategorized" module
        $reassignPostsQuery = 'UPDATE posts SET module_id = :uncategorized_id WHERE module_id = :module_id';
        $stmt = $pdo->prepare($reassignPostsQuery);
        $stmt->execute([':uncategorized_id' => $uncategorizedModuleId, ':module_id' => $moduleId]);

        // Delete the module
        $deleteQuery = 'DELETE FROM modules WHERE id = :id';
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute([':id' => $moduleId]);

        return [
            'success' => true,
            'message' => "Module deleted successfully. Posts have been reassigned to 'Uncategorized'."
        ];
    } else {
        // Delete the module directly if no posts are assigned
        $deleteQuery = 'DELETE FROM modules WHERE id = :id';
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute([':id' => $moduleId]);

        return [
            'success' => true,
            'message' => "Module deleted successfully."
        ];
    }
}

function deleteUser($pdo, $userId) {
    $query = 'DELETE FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $userId]);
}

function getModuleById($pdo, $moduleId) {
    $query = 'SELECT * FROM modules WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $moduleId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateModule($pdo, $moduleId, $moduleName) {
    $query = 'UPDATE modules SET module_name = :module_name WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([':module_name' => $moduleName, ':id' => $moduleId]);
}

function addComment($pdo, $postId, $username, $commentText) {
    try {
       
        $commentText = trim($commentText);

        if (empty($username) || empty($commentText)) {
            throw new Exception("Error: All fields are required.");
        }

        // Check if user exists, if not insert them
        $userQuery = "SELECT id FROM users WHERE username = :username";
        $user = query($pdo, $userQuery, [':username' => $username])->fetch();

        if ($user) {
            $userId = $user['id'];
        } else {
            $insertUserQuery = "INSERT INTO users (username) VALUES (:username)";
            query($pdo, $insertUserQuery, [':username' => $username]);
            $userId = $pdo->lastInsertId();
        }

        // Insert comment
        $insertCommentQuery = "INSERT INTO comments (post_id, user_id, comment_text, created_at) 
                               VALUES (:post_id, :user_id, :comment_text, NOW())";

        query($pdo, $insertCommentQuery, [
            ':post_id' => $postId,
            ':user_id' => $userId,
            ':comment_text' => $commentText
        ]);

        return true; 
    } catch (Exception $e) {
        return "Error: " . $e->getMessage(); 
    }
}
?>