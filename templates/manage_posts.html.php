<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseFunctions.php';

// Fetch all posts
$posts = allPosts($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Posts</title>
    <link rel="stylesheet" href="/coursework/CSS/admin.css">
</head>
<body>
    <div class="management-container" id="manage-posts">
        <h1 class="page-title">Manage Posts</h1>
        <table class="management-table">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Author</th>
                <th>Module</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['id']) ?></td>
                <td><?= htmlspecialchars($post['title']) ?></td>
                <td><?= htmlspecialchars(substr($post['content'], 0, 50)) ?>...</td>
                <td><?= htmlspecialchars($post['created_at']) ?></td>
                <td><?= htmlspecialchars($post['username']) ?></td>
                <td><?= htmlspecialchars($post['module_name']) ?></td>
                <td class="action-buttons">
                    <!-- Edit Form -->
                    <form action="/coursework/view/editpost.php" method="get" class="inline-form">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn edit-btn">Edit</button>
                    </form>

                    <!-- Delete Form -->
                    <form action="/coursework/Admin/delete_post.php" method="post" class="inline-form">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this post?');" class="btn delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>