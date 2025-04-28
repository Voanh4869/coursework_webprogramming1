<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/coursework/CSS/posts.css">
</head>
<body>
    <div class="post-container">
        <?php foreach ($posts as $post): ?>
            <div class="post-card" onclick="window.location.href='/coursework/view/fullpost.php?id=<?= $post['id'] ?>'">
                <div class="post-card__header">
                    <div class="post-user-info">
                        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Icon" class="post-user__image">
                        <h5><?= htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($post['role'], ENT_QUOTES, 'UTF-8') ?>)</h5>
                    </div>
                </div>
                <div class="post-card__body">
                    <h4><?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?></h4>
                    <p><?= nl2br(htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8')) ?></p>
                    <?php if (!empty($post['imgFromStr'])): ?>
                        <img src="/coursework/uploads/<?= htmlspecialchars($post['imgFromStr'], ENT_QUOTES, 'UTF-8') ?>" alt="Post Image" class="post-card__image">
                    <?php else: ?>
                        <img src="https://source.unsplash.com/600x400/?placeholder" alt="Post Image" class="post-card__image">
                    <?php endif; ?>
                    <span class="post-tag post-tag-blue"><?= htmlspecialchars($post['module_name'], ENT_QUOTES, 'UTF-8') ?></span>
                    <br>
                    <br>
                    <small><strong>Posted on:</strong> <?= htmlspecialchars(date("D d M Y", strtotime($post['created_at'])), ENT_QUOTES, 'UTF-8') ?></small>
                    <div class="post-comments-count">
                        <i class="fa fa-comment"></i> <?= $post['comment_count'] ?>
                    </div>
                </div>
                <div class="post-card__footer">
                    <div class="post-action-buttons">
                        <?php if ($_SESSION['role'] === 'admin' || $post['user_id'] === $_SESSION['user_id']): ?>
                            <form action="/coursework/view/editpost.php" method="get" class="post-inline-form">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <button type="submit" class="post-btn post-edit-btn">Edit</button>
                            </form>
                            <form action="/coursework/view/deletepost.php" method="post" class="post-inline-form">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this post?');" class="post-btn post-delete-btn">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

