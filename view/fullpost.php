<?php
try {
    include_once __DIR__ . '/../includes/DatabaseConnection.php';
    include_once __DIR__ . '/../includes/DatabaseFunctions.php';
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        throw new Exception("Invalid post ID.");
    }

    $post_id = (int) $_GET['id'];
    $post = getPostWithComments($pdo, $post_id);

    if (!$post) {
        throw new Exception("Post not found.");
    }

    $comments = $post['comments']; // Extract comments

    $title = htmlspecialchars($post['title']);

    ob_start();
    include __DIR__ . '/../templates/fullpost.html.php';
    $output = ob_get_clean();
} catch (Exception $e) {
    $title = 'An error occurred';
    $output = '<p>Error: ' . $e->getMessage() . '</p>';
}

include __DIR__ . '/../templates/layout.html.php';
?>