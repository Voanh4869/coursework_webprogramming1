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

// Fetch all users
$users = allUsers($pdo);

// Include the HTML template
include '../templates/manage_users.html.php';