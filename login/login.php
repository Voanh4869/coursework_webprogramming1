<?php
include_once '../includes/DatabaseConnection.php'; 

if (isset($_POST['signIn'])) {
    session_start();
    $username_or_email = trim($_POST['username_or_email']);
    $password = trim($_POST['password']);

    if (empty($username_or_email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter both username/email and password.";
        header("Location: ../templates/login.html.php"); 
        exit();
    }

    try {
        // Get user from the database
        $sql = "SELECT * FROM users WHERE email = :username_or_email OR username = :username_or_email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username_or_email' => $username_or_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['login_error'] = " User not found!";
            header("Location: ../templates/login.html.php"); 
            exit();
        }

        // Check password
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role']; // Store the role in the session
            
            unset($_SESSION['login_error']);

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: /coursework/view/index.php"); 
            } else {
                header("Location: /coursework/view/index.php"); 
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password!";
            header("Location: ../templates/login.html.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
        header("Location: ../templates/login.html.php"); 
        exit();
    }
}

header("Location: ../templates/login.html.php"); 
?>
