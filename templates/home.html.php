<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/coursework/includes/DatabaseFunctions.php';
?>

<div class="homepage-container">
    <h2>Welcome to the Student Forum, 
        <?php 
            if (isset($_SESSION['username'])) {
                echo htmlspecialchars($_SESSION['username']); 
            } else {
                echo "Guest"; 
            }
        ?>!
    </h2>

    <p>This is a simple discussion forum where students can ask and answer questions.</p>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="admin-dashboard">
            <h3>Admin Dashboard</h3>
            <ul>
                <li><a href="/coursework/Admin/account.php#manageUsers">Manage Users</a></li>
                <li><a href="/coursework/Admin/account.php#manageModules">Manage Modules</a></li>
                <li><a href="/coursework/Admin/account.php#managePosts">Manage Posts</a></li>
            </ul>
        </div>
    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
        <div class="user-dashboard">
            <h3>User Dashboard</h3>
            <p>Feel free to browse posts, ask questions, and participate in discussions.</p>
            <ul>
                <li><a href="/coursework/view/posts.php">View Posts</a></li>
                <li><a href="/coursework/view/addpost.php">Add a New Post</a></li>
            </ul>
        </div>
    <?php else: ?>
        <div class="guest-section">
            <h3>Guest Access</h3>
            <p>Please log in to participate in the forum.</p>
            <a href="/coursework/Login/login.php" class="btn login-btn">Login</a>
        </div>
    <?php endif; ?>
</div>