<?php
require __DIR__ . '/../login/check.php';

try {
    include_once __DIR__ . '/../includes/DatabaseConnection.php'; 
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';


    // Check if a session is already active before starting a new one
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

// Allow both admins and students to access this page
    if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'student')) {
        header('Location: index.php');
        exit();
    }

    $title = 'List of Posts';
    $posts = allPosts($pdo);
    $totalPosts = totalPosts($pdo);

    // Start output buffering and include the template
    ob_start();
    include __DIR__ . '/../templates/post.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

// Include the main layout template
include __DIR__ . '/../templates/layout.html.php';