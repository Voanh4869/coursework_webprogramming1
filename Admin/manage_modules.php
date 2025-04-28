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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_name'])) {
    $moduleName = trim($_POST['module_name']);
    if (!empty($moduleName)) {
        try {
            addModule($pdo, $moduleName);

            header('Location: ../Admin/account.php#manageModules');
            exit();
        } catch (PDOException $e) {
            $error = 'Error adding module: ' . $e->getMessage();
        }
    } else {
        $error = 'Module name cannot be empty.';
    }
}

// Fetch all modules
$modules = allModules($pdo);

// Include the HTML template
include '../templates/manage_modules.html.php';