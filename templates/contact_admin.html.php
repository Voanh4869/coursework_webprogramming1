<!DOCTYPE html>
<html>
<head>
    <title>Contact Admin</title>
    <link rel="stylesheet" href="/coursework/CSS/posts.css">
</head>
<body>
    <div class="form-container">
        <h2>Contact Admin</h2>

        <!-- Success/Error Message Container -->
        <div id="response-message"></div>

        <!-- Contact Form -->
        <form id="contact-form" method="post" action="/coursework/view/contact_admin.php">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>

    <script src="/coursework/JS/script.js"></script>
</body>
</html>