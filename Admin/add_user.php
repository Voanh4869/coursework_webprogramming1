<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseFunctions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Validate username
    if (empty($username)) {
        $errors['add_user_error'] = "Username is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors['add_user_error'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['add_user_error'] = "Invalid email format.";
    }

    // Validate password
    if (empty($password)) {
        $errors['add_user_error'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['add_user_error'] = "Password must be at least 6 characters.";
    }

    // Validate role
    if (empty($role)) {
        $errors['add_user_error'] = "Role is required.";
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $errors['add_user_error'] = "Username or Email already exists.";
    }

    // If no errors, insert user into database
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if (insertUser($pdo, $username, $email, $hashed_password, $role)) {
                $_SESSION['add_user_success'] = "User added successfully.";
                header("Location: account.php#manageUsers");
                exit();
            } else {
                $errors['add_user_error'] = "Failed to add user.";
            }
        } catch (PDOException $e) {
            $errors['add_user_error'] = "Database error: " . $e->getMessage();
        }
    }

    // Store errors in session so they appear in the form
    $_SESSION['add_user_error'] = reset($errors);
    header("Location: /coursework/templates/add_user.html.php");
    exit();
}
?>