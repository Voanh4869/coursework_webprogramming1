<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = isset($_SESSION['register_error']) ? $_SESSION['register_error'] : '';
unset($_SESSION['register_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/coursework/CSS/auth.css">
</head>
<body>
<script src="/coursework/JS/script.js"></script>

<div class="auth-wrapper">
    <div class="page-header">
        <h1>Student Forum</h1>
        <p>Student Forum is a place where students connect, share ideas, and support each other's academic journeys. Join discussions, ask questions, and grow together with a vibrant student community.</p>
    </div>

<div class="auth-container">
    <h1 class="form-title">Sign Up</h1>

    <?php if (!empty($error)): ?>
    <p id="register-error" style="color: red; font-weight: bold;">
        <?= htmlspecialchars($error) ?>
    </p>
    <?php endif; ?>

    <form method="post" action="../login/register.php">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i id="togglePassword" class="fa fa-eye" style="cursor: pointer;"></i>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
            <i id="toggleConfirmPassword" class="fa fa-eye" style="cursor: pointer;"></i>
        </div>

        <input type="submit" class="btn" value="Sign Up" name="register">
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
        <p>Already have an account?</p>
        <a href="../login/login.php"><button>Sign In</button></a>
    </div>
</div>
</div>

</body>
</html>
