<?php
session_start();


$target_dir = __DIR__ . '/../uploads/';


if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}


if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['upload_error'] = "File is not an image.";
        $uploadOk = 0;
    }

  
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $_SESSION['upload_error'] = "File is too large.";
        $uploadOk = 0;
    }


    $allowed_types = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowed_types)) {
        $_SESSION['upload_error'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if upload is allowed
    if ($uploadOk == 0) {
        $_SESSION['upload_error'] = "File was not uploaded.";
    } else {
        // Attempt to move the file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION['upload_success'] = "The file " . htmlspecialchars($file_name) . " has been uploaded.";
        } else {
            $_SESSION['upload_error'] = "There was an error uploading your file.";
        }
    }
} else {
    $_SESSION['upload_error'] = "No file uploaded.";
}

header("Location: addpost.php");
exit();
?>
