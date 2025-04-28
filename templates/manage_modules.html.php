<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseFunctions.php';

// Fetch all modules
$modules = allModules($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Modules</title>
    <script src="/coursework/JS/script.js"></script>
    <link rel="stylesheet" href="/coursework/CSS/admin.css">
</head>
<body>
    <div class="management-container" id="manage-modules">
        <h1 class="page-title">Manage Modules</h1>

        <?php if (isset($_SESSION['module_delete_error'])): ?>
            <p id="delete-error" class="error-message">
                <?= htmlspecialchars($_SESSION['module_delete_error']); ?>
            </p>
            <?php unset($_SESSION['module_delete_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['module_delete_success'])): ?>
            <p id="delete-success" class="success-message">
                <?= htmlspecialchars($_SESSION['module_delete_success']); ?>
            </p>
            <?php unset($_SESSION['module_delete_success']); ?>
        <?php endif; ?>

        <!-- Form for Adding New Module -->
        <form action="../Admin/manage_modules.php" method="post" id="add-module-form">
            <label for="module_name">New Module Name:</label>
            <input type="text" id="module_name" name="module_name" required>
            <button type="submit" class="btn save-btn">Add Module</button>
        </form>
        <br>
        <table class="management-table">
            <tr>
                <th>ID</th>
                <th>Module Name</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= htmlspecialchars($module['id']) ?></td>
                <td>
                    <input type="text" id="module-name-<?= $module['id'] ?>" value="<?= htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8') ?>">
                </td>
                <td class="action-buttons">
                    <button class="btn save-btn" onclick="saveModule(<?= $module['id'] ?>)">Save</button>
                    <form action="/coursework/Admin/delete_module.php" method="post" class="inline-form">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this module?');" class="btn delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>