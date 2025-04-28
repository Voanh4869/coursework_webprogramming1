<?php
session_start(); 

$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/coursework/CSS/auth.css">
</head>
<body>
<script src="/coursework/JS/script.js"></script>

<div class="auth-wrapper">
    <!-- Title and Description -->
    <div class="page-header">
        <h1>Student Forum</h1>
        <p>Student Forum is a place where students connect, share ideas, and support each other's academic journeys. Join discussions, ask questions, and grow together with a vibrant student community.</p>
    </div>

    <!-- Login Form Container -->
    <div class="auth-container">
        <h1 class="form-title">Sign In</h1>

        <?php if (!empty($error)): ?>
        <p id="login-error" style="color: red; font-weight: bold;">
            <?= htmlspecialchars($error) ?>
        </p>
        <?php endif; ?>
        
        <form method="post" action="../login/login.php">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username_or_email" id="username_or_email" placeholder="Username or Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i id="togglePassword" class="fa fa-eye" style="cursor: pointer;"></i>
            </div>

            <p class="recover"><a href="#">Recover Password</a></p>

            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>

        <p class="or">----------or----------</p>
        <div class="auth-icons">
            <a href="your-google-login-url" class="google-login">
                <i class="fab fa-google"></i>
            </a>
            <a href="https://www.facebook.com/login/?" class="facebook-login">
                <i class="fab fa-facebook"></i>
            </a>
        </div>

        <div class="auth-links">
            <p>Don't have an account yet?</p>
            <a href="../login/Register.php"><button>Sign Up</button></a>
        </div>
    </div>
</div>

</body>
</html>
