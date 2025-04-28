<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseConnection.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseFunctions.php';

// Fetch all users
$users = allUsers($pdo);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="/coursework/CSS/admin.css">
</head>
<body>
    <div class="management-container" id="manage-users">
        <h1 class="page-title">Manage Users</h1>
        <form action="/coursework/templates/add_user.html.php" method="get" class="inline-form">
            <button type="submit" class="btn add-btn">Add New User</button>
        </form>
        <br>
        <br>
        <table class="management-table">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td><?= htmlspecialchars($user['created_at']) ?></td>
                <td class="action-buttons">
                    <!-- Edit Form -->
                    <form action="/coursework/Admin/edit_user.php" method="get" class="inline-form">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn edit-btn">Edit</button>
                    </form>

                    <!-- Delete Form -->
                    <form action="/coursework/Admin/delete_user.php" method="post" class="inline-form">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');" class="btn delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>