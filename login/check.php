<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = 'You must log in first to access this page.';
    header('Location: ../login/login.php'); 
    exit();
}