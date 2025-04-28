<?php
session_start(); // Start session to access stored username

if (isset($_POST['title'])) {
    try {
        include_once __DIR__ . '/../includes/DatabaseConnection.php';
        include_once __DIR__ . '/../includes/DatabaseFunctions.php';

        // Get the username from the session
        if (!isset($_SESSION['username'])) {
            throw new Exception("You must be logged in to add a post.");
        }

        $username = $_SESSION['username'];

        // Fetch user_id from the session instead of querying the database
        if (!isset($_SESSION['user_id'])) {
            // Fetch user_id from the database if not already stored in session
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if (!$user) {
                throw new Exception("Error: User not found.");
            }

            $_SESSION['user_id'] = $user['id']; 
        }

        $user_id = $_SESSION['user_id'];

        // Handle image upload
        $imagePath = null; // Default to null if no image is uploaded
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            // Use an absolute path for the uploads directory
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/coursework/uploads/';
            
            // Ensure the uploads directory exists
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0777, true)) {
                    throw new Exception("Failed to create uploads directory.");
                }
            }

            $targetFile = $targetDir . basename($_FILES['fileToUpload']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Validate image file
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
                throw new Exception("There was an error uploading your file.");
            }

            // Save the image filename
            $imagePath = basename($_FILES['fileToUpload']['name']);
        }

        // Insert post using the function
        insertPost($pdo, $_POST['title'], $_POST['content'], $user_id, $_POST['module_id'], $imagePath);

        // Redirect to the posts list
        header('Location: posts.php');
        exit;
    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage();
    }
} else { 
    include_once __DIR__ . '/../includes/DatabaseConnection.php'; 
    include_once __DIR__ . '/../includes/DatabaseFunctions.php'; 

    $title = 'Add a new post';

    $modules = allModules($pdo);

    ob_start();
    include __DIR__ . '/../templates/addpost.html.php';
    $output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';
?>
