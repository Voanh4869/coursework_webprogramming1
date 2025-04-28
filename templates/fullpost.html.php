<div class="fullpost-container">
    <div class="fullpost-card">
        <div class="fullpost-card__header">
            <div class="fullpost-user-info">
                <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Icon" class="fullpost-user__image">
                <h5><?= htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($post['role'], ENT_QUOTES, 'UTF-8') ?>)</h5>
            </div>
        </div>
        <div class="fullpost-card__body">
            <h4><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></h4>
            <p><?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?></p>
            <?php if (!empty($post['imgFromStr'])): ?>
                <img src="/coursework/uploads/<?= htmlspecialchars($post['imgFromStr'], ENT_QUOTES, 'UTF-8') ?>" alt="Post Image" class="fullpost-card__image">
            <?php endif; ?>
            <span class="fullpost-tag fullpost-tag-blue"><?= htmlspecialchars($post['module_name'], ENT_QUOTES, 'UTF-8') ?></span>
            <br>
            <br>
            <small><strong>Posted on:</strong> <?= htmlspecialchars(date("D d M Y", strtotime($post['created_at'])), ENT_QUOTES, 'UTF-8') ?></small>
        </div>
        <div class="fullpost-card__footer"> 
                <div class="fullpost-comment-form">
                <h3>Comments (<?= $post['comment_count'] ?>)</h3>
                <form action="/coursework/view/addcomment.php" method="POST" >
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <textarea name="comment_text" rows="4" required></textarea>
                    <button type="submit">Post Comment</button>
                </form>
            <div class="fullpost-comments-section">
                <?php if (empty($comments)): ?>
                    <p>No comments yet. Be the first to comment!</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="fullpost-comment-box">
                            <p><strong><?= htmlspecialchars($comment['username'], ENT_QUOTES, 'UTF-8') ?></strong></p>
                            <p><?= nl2br(htmlspecialchars($comment['comment_text'], ENT_QUOTES, 'UTF-8')) ?></p>
                            <p class="fullpost-comment-time"><?= date("D d M Y H:i", strtotime($comment['created_at'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</div>
