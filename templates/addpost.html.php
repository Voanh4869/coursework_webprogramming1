<div class="form-container">
    <form action="/coursework/view/addpost.php" method="post" enctype="multipart/form-data">
        
        <!-- Hidden User ID -->
        <input type="hidden" name="user_id" value="<?= $_POST['user_id'] ?? ''; ?>">

        <!-- Title -->
        <label for="title">Post Title</label>
        <input type="text" name="title" id="title" required>

        <!-- Content -->
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="4" required></textarea>

        <!-- Image -->
        <label for="fileToUpload">Select image to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*">

        <!-- Module Selection -->
        <label for="module_id">Select Module</label>
        <select style="height: 40px; width: 400px;" name="module_id" id="module_id" required>
            <option value="" disabled selected>Select a module</option>
            <?php foreach ($modules as $module): ?>
                <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Submit Button -->
        <button type="submit" name="submit">Add Post</button>
    </form>
</div>
