<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/DatabaseConnection.php';
require_once '../includes/DatabaseFunctions.php';

// Check if the user is an admin
if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Check if the post ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $postId = intval($_POST['id']);

    try {
        // Delete the post using the deletePost function
        deletePost($pdo, $postId);

        // Redirect back to the "Manage Posts" tab
        header('Location: ../Admin/account.php#managePosts');
        exit();
    } catch (Exception $e) {
        $error = 'Error deleting post: ' . $e->getMessage();
    }
} else {
    $error = 'Invalid post ID.';
}

header('Location: ../Admin/account.php#managePosts');
exit();