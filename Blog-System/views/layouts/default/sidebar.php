<aside class="col-md-3">
    <form class="input-group form-group" method="post" action="/posts/search">
        <input type="text" class="form-control" placeholder="Search posts..." name="search-data">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>
        </span>
    </form>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="text-center">Most popular tags</h4>
        </div>
        <ul class="list-unstyled text-center panel-body">
        <?php if ($this->sidebarController->tags): foreach ($this->sidebarController->tags as $tag): ?>
        <li><?= $tag ?></li>
        <?php endforeach; else: ?>
        <li>No tags found</li>
        <?php endif; ?>
        </ul>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="text-center">Archive</h4>
        </div>
        <ul class="list-unstyled text-center panel-body">
        <?php if ($this->sidebarController->dates): foreach ($this->sidebarController->dates as $date): ?>
        <li>
            <a href="/posts/byDate/<?= $date['year'] . '/' . $date['month'] ?>"><?= $date['monthname'] . ' ' . $date['year'] ?></a>
        </li>
        <?php endforeach; else: ?>
            <li>No posts found</li>
        <?php endif; ?>
        </ul>
</aside>
