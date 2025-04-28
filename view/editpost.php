<?php
include_once __DIR__ . '/../includes/DatabaseConnection.php';
include_once __DIR__ . '/../includes/DatabaseFunctions.php';

session_start(); // Start session to access user data

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("You must be logged in to edit a post.");
    }

    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    if (isset($_POST['postid'])) {
     
        $newImagePath = $_POST['existing_image'];

        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../uploads/'; 
            // Ensure the directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Get the file name and its extension
            $fileName = basename($_FILES['fileToUpload']['name']);
            $targetFile = $targetDir . $fileName;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Validate the uploaded file
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if ($check === false) {
                throw new Exception("File is not an image.");
            }

            // Allow only certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed.");
            }

            // Move the uploaded file to the uploads directory
            if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                throw new Exception("There was an error uploading your file to: " . $targetFile);
            }

            // Update the image path to be stored in the database
            $newImagePath = $fileName;
        } else {
            // If no new file is uploaded, retain the existing image
            $newImagePath = $_POST['existing_image'];
        }

      
        // Update the post
        updatePost($pdo, $_POST['postid'], $_POST['title'], $_POST['content'], $_POST['module_id'], $newImagePath);

        // Redirect to the posts list
        header('Location: /coursework/view/posts.php');
        exit();
    } else {
        // Fetch the post to edit
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            throw new Exception("Invalid post ID.");
        }

        $post = getPost($pdo, $_GET['id']);
        if (!$post) {
            throw new Exception("Post not found.");
        }

        // Check if the user has permission to edit the post
        if ($role !== 'admin' && $post['user_id'] !== $user_id) {
            throw new Exception("You do not have permission to edit this post.");
        }

        $title = 'Edit Post';

        // Fetch all modules for the dropdown
        $modules = $pdo->query('SELECT * FROM modules')->fetchAll();

        ob_start();
        include __DIR__ . '/../templates/editpost.html.php';
        $output = ob_get_clean();
    }
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Error editing post: ' . $e->getMessage();
} catch (Exception $e) {
    $title = 'An error has occurred';
    $output = 'Error: ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';
?>