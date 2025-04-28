<div class="edit-post-container">
    <h2>Edit Post</h2>
    <form action="/coursework/view/editpost.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="postid" value="<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">

        <label for="title">Edit your title here:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>" required>
        <br>

        <label for="content">Edit your content here:</label>
        <textarea id="content" name="content" rows="5" required><?= htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
        <br>

        <?php if (!empty($post['imgFromStr'])): ?>
            <label>Current Image:</label>
            <br>
            <img src="/coursework/uploads/<?= htmlspecialchars($post['imgFromStr'], ENT_QUOTES, 'UTF-8'); ?>" alt="Post Image" style="max-width: 200px; max-height: 200px; display:block; margin-bottom:10px;">
        <?php endif; ?>

        <!-- Image Upload -->
        <label for="fileToUpload">Change Image</label>
        <input type="file" name="fileToUpload" id="fileToUpload">

        <input type="hidden" name="existing_image" value="<?= htmlspecialchars($post['imgFromStr'], ENT_QUOTES, 'UTF-8'); ?>">
        <br>

        <label for="module_id">Select a Module:</label>
        <select id="module_id" name="module_id" required>
            <?php foreach ($modules as $module): ?>
                <option value="<?= htmlspecialchars($module['id'], ENT_QUOTES, 'UTF-8') ?>" 
                    <?= $module['id'] == $post['module_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($module['module_name'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="submit" class="btn save-btn">Save</button>
            <form action="/coursework/view/posts.php" method="get" class="inline-form">
                <button type="submit" class="btn cancel-btn" style="background-color: red; color: white;">Cancel</button>
            </form>
        </div>
    </form>
</div>
