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



$title = 'Admin Account';

ob_start();

$output = ob_get_clean();

include '../templates/layout.html.php';
?>
<?php if (isset($_SESSION['module_delete_error'])): ?>
    <p style="color: red; font-weight: bold;">
        <?= $_SESSION['module_delete_error']; unset($_SESSION['module_delete_error']); ?>
    </p>
<?php endif; ?>

<?php if (isset($_SESSION['module_delete_success'])): ?>
    <p style="color: green; font-weight: bold;">
        <?= $_SESSION['module_delete_success']; unset($_SESSION['module_delete_success']); ?>
    </p>
<?php endif; ?>
