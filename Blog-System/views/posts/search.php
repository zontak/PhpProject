<?php if ($this->posts): foreach ($this->posts as $post): ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <a href="/posts/view/<?= $post['id'] ?>"><h2 class="margin-top-bottom"><?= htmlspecialchars($post['title']) ?></h2></a>
            <p>Posted on <strong><?= $post['date'] ?></strong> by <strong><?= htmlspecialchars($post['username']) ?></strong></p>
        </div>
    </div>
<?php endforeach; else: ?>
    <h3>No posts were found.</h3>
<?php endif; ?>
