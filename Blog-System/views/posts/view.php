<?php if ($this->currentPost): ?>
<div class="row panel panel-success">
    <div class="panel-heading">
        <div class="margin-top-bottom">
            Posted on <strong><?= $this->currentPost['date'] ?></strong>
            by <strong><?= htmlspecialchars($this->currentPost['username']) ?></strong>
            <?php if ($this->isAdmin()): ?>&nbsp;
            <a href="/posts/edit/<?= $this->currentPost['id'] ?>">
                <span class="glyphicon glyphicon-edit" aria-hidden="true">
            </span></a>
            <a href="#" data-toggle="modal" data-target="#deletePostModal">
                <span class="glyphicon glyphicon-remove" aria-hidden="true">
            </span></a>
            <div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title text-tcenter" id="myModalLabel">Are you sure you want to delete this post?</h5>
                        </div>
                        <div class="modal-footer">
                            <a type="button" href="/posts/delete/<?= $this->currentPost['id'] ?>" class="btn btn-primary">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
        </div>
        <p>Visited: <strong><?= $this->currentPost['visits'] ?></strong> times</p>
        <p>Tagged: <?= implode(', ', $this->tags) ?></p>
    </div>
    <p class="panel-body no-margin-bottom"><?= nl2br(htmlspecialchars($this->currentPost['text'])) ?></p>
</div>

<div class="row panel panel-success">
    <div class="panel-heading">Comments: </div>
    <div class="panel-body no-padding-bottom">
        <?php if ($this->comments): foreach ($this->comments as $comment): ?>
        <div class="panel panel-success">
            <p class="panel-heading">
                <strong><?= htmlspecialchars($comment['username']) ?></strong> wrote at <strong><?= $comment['date'] ?></strong>
                <?php if ($this->isAdmin()): ?>&nbsp;
                <a href="/comments/delete/<?= $this->currentPost['id'] . '/' . $comment['id'] ?>">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true">
                </span></a>
                <?php endif; ?>
            </p>
            <p class="panel-body single-comment-panel"><?= htmlspecialchars($comment['text']) ?></p>
        </div>
        <?php endforeach; else: ?>
            <p>This post don't have any comments yet.</p>
        <?php endif; ?>
    </div>
</div>

<form method="post" class="panel panel-primary no-margin-bottom row" action="/comments/add/<?= $this->currentPost['id'] ?>">
    <p class="panel-heading">
        <label for="commentContent" class="no-margin-bottom">Add a comment:</label>
    </p>
    <div class="panel-body single-comment-panel">
        <?php if (!$this->isLoggedIn()): ?>
        <input type="text" name="username" id="username" class="form-control form-group" placeholder="Enter your name...">
        <?php endif; ?>
        <textarea name="comment" id="commentContent" class="form-control" rows="3" placeholder="Enter your comment..."></textarea>
        <input type="hidden" name="form-token" value="<?= $_SESSION['form-token'] ?>">
        <button type="submit" class="btn btn-primary margin-top-bottom">Comment</button>
    </div>
</form>

<?php else: ?>
    <h3>Such post do not exist.</h3>
<?php endif; ?>
