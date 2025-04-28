<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/coursework/CSS/posts.css">
    <script src="/coursework/JS/script.js"></script>
</head>
<body>

<header class="header-nav-container">
    <h1 class="site-title">Student Forum</h1>
    <div class="nav-container">
        <nav>
            <a href="/coursework/view/index.php">Home</a>
            <a href="/coursework/view/posts.php">List of Posts</a>
            <a href="/coursework/view/addpost.php">Add Post</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <a href="/coursework/templates/contact_admin.html.php" id="contact-tab" data-action="load-contact-form">Contact</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/coursework/Admin/account.php">Admin</a>
            <?php endif; ?>
        </nav>

        <div class="signIN-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="/coursework/login/logout.php" method="post">
                    <button type="submit" onclick="return confirm('Are you sure you want to logout?');" class="btn logout-btn">Logout</button>
                </form>
            <?php else: ?>
                <form action="/coursework/login/login.php" method="get">
                    <button type="submit" class="btn login-btn">Login</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</header>


<main>
    <?php if ($title === 'Admin Account'): ?>
        <h1>Welcome to the Admin Management Page</h1>
        <p>Use the navigation bar below to manage users, modules, and posts.</p>

        <!-- Management Navigation Bar -->
        <div class="management-nav">
            <a href="#manageUsers" class="tab-link" data-tab="manageUsers">Manage Users</a>
            <a href="#manageModules" class="tab-link" data-tab="manageModules">Manage Modules</a>
            <a href="#managePosts" class="tab-link" data-tab="managePosts">Manage Posts</a>
        </div>

        <!-- Tab Contents -->
        <div id="manageUsers" class="tab-content">
            <?php include '../Admin/manage_users.php'; ?>
        </div>
        <div id="manageModules" class="tab-content">
            <?php include '../Admin/manage_modules.php'; ?>
        </div>
        <div id="managePosts" class="tab-content">
            <?php include '../Admin/manage_posts.php'; ?>
        </div>
    <?php else: ?>
        <?= $output ?>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?= date('Y'); ?> Student Forum. All rights reserved.</p>
</footer>



</body>
</html>
