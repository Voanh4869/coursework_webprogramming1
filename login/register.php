<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/DatabaseConnection.php';
include_once '../includes/DatabaseFunctions.php';

$errors = [];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate username
    if (empty($username)) {
        $errors['register_error'] = "Username is required.";
    }

    // Validate email
    if (empty($email)) {
        $errors['register_error'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['register_error'] = "Invalid email format.";
    }

    // Validate password
    if (empty($password)) {
        $errors['register_error'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['register_error'] = "Password must be at least 6 characters.";
    }

    // Check password confirmation
    if ($password !== $confirm_password) {
        $errors['register_error'] = "Passwords do not match.";
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        $errors['register_error'] = "Username or Email already exists.";
    }

    // If no errors, insert user into database
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'student'; 
            insertUser($pdo, $username, $email, $hashed_password, $role);
            $_SESSION['success_message'] = "Registration successful! You can now log in.";
            header("Location: ../login/login.php");
            exit();
        } catch (PDOException $e) {
            $errors['register_error'] = "Database error: " . $e->getMessage();
        }
    }

    // Store errors in session so they appear in the form
    $_SESSION['register_error'] = reset($errors); 
}

// Reload the registration form
include '../templates/register.html.php';
