<?php
try {
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';
    
    deletePost($pdo, $_POST['id']);
    header('location: posts.php');
    exit();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Unable to delete post: ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php'; 
?>