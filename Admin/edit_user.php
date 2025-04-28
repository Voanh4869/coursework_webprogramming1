<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/DatabaseConnection.php';
require_once '../includes/DatabaseFunctions.php';

if (!isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Fetch user details
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = intval($_GET['id']);
    $user = query($pdo, 'SELECT * FROM users WHERE id = :id', [':id' => $userId])->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: account.php#manageUsers');
        exit();
    }
} else {
    header('Location: account.php#manageUsers');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    if (!empty($username) && !empty($email) && !empty($role)) {
        try {
            query($pdo, 'UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id', [
                ':username' => $username,
                ':email' => $email,
                ':role' => $role,
                ':id' => $userId
            ]);

            // Redirect back to the "Manage Users" tab
            header('Location: account.php#manageUsers');
            exit();
        } catch (Exception $e) {
            $error = 'Error updating user: ' . $e->getMessage();
        }
    } else {
        $error = 'All fields are required.';
    }
}

include '../templates/edit_user.html.php';
?>