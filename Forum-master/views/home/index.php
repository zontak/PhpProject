      <div class="container">
         ::before
         <div class="page-header" id="banner">
            <h1>Questions</h1>
         </div>
         <a href="question/add" class="btn btn-primary">Add Question</a>
         <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
               <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
         </form>
        <?php foreach ($this->posts as $post) : ?>
         <div class="ItemContent Discussion">
            <div class="Title">
            <span class="label label-success">new</span>
               <a href="question/preview/<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
            </div>
            <div class="Meta Meta-Discussion">
               <span class="MItem MCount ViewCount"><span title="# views" class="Number">#</span> <?= htmlspecialchars($post['visits']) ?></span>
               <span class="MItem MCount CommentCount"><span title="# comments" class="Number">#</span> comments</span>
               <span class="MItem MCount DiscussionScore Hidden"><span title="# points" class="Number">#</span> points</span>
               <span class="MItem LastCommentBy">Most recent by <a href="#"><?= $post['author'] ?></a></span>  <span class="MItem LastCommentDate"><time title="#" datetime="#"><?= htmlspecialchars($post['date']) ?></time></span><span class="MItem Category Category-#"><a href="#Linkcategory"><?= htmlspecialchars($post['category']) ?></a></span>
            </div>
         </div>
         <br>
         <?php endforeach; ?>
      </div>