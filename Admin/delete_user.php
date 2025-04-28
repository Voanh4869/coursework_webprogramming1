<?php
include_once '../includes/DatabaseConnection.php';
include_once '../includes/DatabaseFunctions.php';

session_start();

// Check if the user is an admin
if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Check if the user ID is provided via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $userId = intval($_POST['id']);
    try {
        deleteUser($pdo, $userId); // Call the delete function
    } catch (Exception $e) {
        // Handle any errors during deletion
        $error = 'Error deleting user: ' . $e->getMessage();
    }
}


header('Location: ../Admin/account.php#manageUsers');
exit();