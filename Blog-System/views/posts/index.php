<?php if ($this->currentPost): ?>
<div class="row panel panel-success">
    <div class="panel-heading">
        <a href="/posts/view/<?= $this->currentPost['id'] ?>"><h2 class="no-margin-top"><?= htmlspecialchars($this->currentPost['title']) ?></h2></a>
        Posted on <strong><?= $this->currentPost['date'] ?></strong>
        by <strong><?= htmlspecialchars($this->currentPost['username']) ?></strong>
        <p>Tagged: <?= implode(', ', $this->tags) ?></p>
    </div>
    <p class="panel-body"><?= nl2br(htmlspecialchars($this->currentPost['text'])) ?></p>
</div>

<ul class="pager">
    <?php if ($this->currentPage > 0): ?>
    <li class="previous"><a href="/posts/index/<?= $this->currentPage - 1 ?>">← Next post</a></li>
    <?php endif; if ($this->currentPage < $this->totalPosts - 1): ?>
    <li class="next"><a href="/posts/index/<?= $this->currentPage + 1 ?>">Previous post →</a></li>
    <?php endif; ?>
</ul>

<?php else: ?>
    <h3>This blog do not have any posts yet.</h3>
<?php endif; ?>
