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

// Check if the module ID is provided via POST
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $moduleId = intval($_POST['id']);

    // Call the deleteModule function
    $result = deleteModule($pdo, $moduleId);

    // Set the appropriate session message based on the result
    if ($result['success']) {
        $_SESSION['module_delete_success'] = $result['message'];
    } else {
        $_SESSION['module_delete_error'] = $result['message'];
    }
}

// Redirect back to the manage modules page
header('Location: ../Admin/account.php#manageModules');
exit();
