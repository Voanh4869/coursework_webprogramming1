<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="/coursework/CSS/admin.css"> 
</head>
<body>
    <div class="edit-user-form">
        <h1>Edit User</h1>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
            </select>

            <button type="submit" class="btn save-btn">Update User</button>
        </form>

        <form action="/coursework/Admin/account.php#manageUsers" method="get">
            <button type="submit" class="btn cancel-btn">Cancel</button>
        </form>
        
    </div>
</body>
</html>