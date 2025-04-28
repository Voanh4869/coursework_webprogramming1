<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="/coursework/CSS/admin.css">
</head>
<body>
    <div class="form-container">
        <h1>Add New User</h1>

        <?php if (isset($_SESSION['add_user_error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_SESSION['add_user_error']) ?></p>
            <?php unset($_SESSION['add_user_error']); ?>
        <?php endif; ?>

        <form action="/coursework/Admin/add_user.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="text" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="btn submit-btn">Add User</button>
        </form>

  
        <form action="/coursework/Admin/account.php#manageUsers" method="get" class="inline-form">
            <button type="submit" class="btn cancel-btn">Cancel</button>
        </form>
    </div>
</body>
</html>