<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/DatabaseConnection.php';
require_once '../includes/DatabaseFunctions.php';

if (!isAdmin()) {
    echo 'Access denied.';
    exit();
}

// Handle inline editing via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_id'], $_POST['module_name'])) {
    $moduleId = intval($_POST['module_id']);
    $moduleName = trim($_POST['module_name']);

    if (!empty($moduleName)) {
        try {
            updateModule($pdo, $moduleId, $moduleName);
            echo 'success';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Module name cannot be empty.';
    }
    exit();
}
?>