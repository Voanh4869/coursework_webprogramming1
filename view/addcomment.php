<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';

    session_start(); // Ensure session is started
    $postId = $_POST['post_id'];
    $username = $_SESSION['username'] ?? null; // Get username from session
    $commentText = $_POST['comment_text'];

    
    $result = addComment($pdo, $postId, $username, $commentText);

    if ($result === true) {
        header("Location: fullpost.php?id=" . $postId);
        exit;
    } else {
        echo $result; // Display error message
    }
}
?>
