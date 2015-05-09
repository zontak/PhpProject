<?php if ($this->currentPost): ?>
<form method="post">
    <div class="form-group">
        <label for="title">Title: </label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $this->currentPost['title'] ?>">
    </div>
    <div class="form-group">
        <label for="tags">Tags (comma separated): </label>
        <input type="text" name="tags" id="tags" class="form-control" value="<?= implode(', ', $this->tags) ?>">
    </div>
    <div class="form-group">
        <label for="postContent">Post content: </label>
        <textarea name="text" id="postContent" class="form-control" rows="20"><?= $this->currentPost['text'] ?></textarea>
    </div>
    <input type="hidden" name="form-token" value="<?= $_SESSION['form-token'] ?>">
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block">Edit Post</button>
    </div>
</form>

<?php else: ?>
    <h3>Such post do not exist.</h3>
<?php endif; ?>
