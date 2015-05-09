<?php

class PostsController extends BaseController {
    const MIN_POST_LENGTH = 10;
    const MIN_TITLE_LENGTH = 2;
    const PREVIEW_LENGTH = 1995;

    protected function onInit() {
        $this->title = 'zontak\'s Blog';
    }

    public function index($page = 0) {
        $this->totalPosts = $this->postsModel->count();

        if ($page !== 0) {
            if (!ctype_digit($page) || $page >= $this->totalPosts) {
                $this->redirect(DEFAULT_CONTROLLER);
            }
        }

        $this->currentPage = $page;
        $this->currentPost = $this->postsModel->getLast($page);
        if ($this->currentPost) {
            $this->tags = $this->getPreparedTags($this->currentPost->sharedTags);
            if (strlen($this->currentPost['text']) >= self::PREVIEW_LENGTH) {
                $this->currentPost['text'] = substr($this->currentPost['text'], 0, self::PREVIEW_LENGTH) . ' ...';
            }
        }
    }

    public function view($postId) {
        $this->setFormToken();
        $this->getPostData($postId);
        if ($this->currentPost) {
            $this->tags = $this->getPreparedTags($this->currentPost->sharedTags);
        }
    }

    public function search() {
        if (!isset($_POST['search-data'])) {
            $this->redirect(DEFAULT_CONTROLLER);
        }

        $searchData = trim($_POST['search-data']);
        $words = array_filter(preg_split('/[^a-z0-9а-я]+/ui', $searchData));
        $this->title = 'Search results for ' . $searchData;
        $this->posts = $this->postsModel->getBySearchData($words);
    }

    public function byTag($tag) {
        $tag = urldecode($tag);
        $this->title = 'Posts tagged as ' . $tag;
        $this->posts = $this->postsModel->getByTag($tag);
    }

    public function byDate($year, $month = null) {
        if (!$year || !ctype_digit($year) || ($month && !ctype_digit($month))) {
            $this->redirect(DEFAULT_CONTROLLER);
        }

        $monthName = $month ? date('F', mktime(0, 0, 0, $month, 1, 2015)) : '';
        $this->title = "Posts from $monthName $year";
        $this->posts = $this->postsModel->getByDate($year, $month);
    }

    public function add() {
        $this->authorizeAdmin();
        $this->setFormToken();
        $this->title = 'Add New Post';
        if ($this->isPost()) {
            $this->addPost();
        }
    }

    public function edit($postId) {
        $this->authorizeAdmin();
        $this->setFormToken();
        $this->getPostData($postId);
        if ($this->currentPost) {
            $this->tags = $this->getStringTags($this->currentPost->sharedTags);
        }

        if ($this->isPost()) {
            $this->editPost($postId);
        }
    }

    public function delete($postId) {
        $this->authorizeAdmin();
        $this->postsModel->delete($postId);
        $this->addSuccessMessage('Post deleted.');
        $this->redirect(DEFAULT_CONTROLLER);
    }

    private function addPost() {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid post data.');
            return;
        }

        if (($title = $this->validatePostTitle()) && $content = $this->validatePostContent()) {
            $tags = array_filter(array_map('trim', explode(',', $_POST['tags'])));
            $postId = $this->postsModel->create($title, $content, $tags);
            if (!$postId) {
                $this->addErrorMessage('Error in creating post.');
                return;
            }

            $this->addSuccessMessage('New post created.');
            $this->redirect('posts', 'view', [$postId]);
        }
    }

    private function editPost($postId) {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid post data.');
            return;
        }

        if (($title = $this->validatePostTitle()) && $content = $this->validatePostContent()) {
            $tags = array_filter(array_map('trim', explode(',', $_POST['tags'])));
            if (!$this->postsModel->edit($postId, $title, $content, $tags)) {
                $this->addErrorMessage('Error in post editing.');
                return;
            }

            $this->addSuccessMessage('Post edited successfully.');
            $this->redirect('posts', 'view', [$postId]);
        }
    }

    private function validatePostTitle() {
        $title = trim($_POST['title']);
        if (strlen($title) < self::MIN_TITLE_LENGTH) {
            $this->addErrorMessage('The post title must be at least ' . self::MIN_TITLE_LENGTH . ' characters long.');
            return null;
        }

        return $title;
    }

    private function validatePostContent() {
        $content = trim($_POST['text']);
        if (strlen($content) < self::MIN_POST_LENGTH) {
            $this->addErrorMessage('The post content must be at least ' . self::MIN_POST_LENGTH . ' characters long.');
            return null;
        }

        return $content;
    }

    private function getPostData($postId) {
        $this->currentPost = $this->postsModel->getById($postId);
        if ($this->currentPost) {
            $this->title = $this->currentPost['title'];
            $this->comments = $this->postsModel->getComments($this->currentPost['id']);
        }
    }

    private function getPreparedTags($tags) {
        $preparedTags = array_map(function ($tag) {
            $htmlEscaped = htmlspecialchars($tag['tag']);
            $urlEncoded = urlencode($tag['tag']);
            return "<a href='/posts/byTag/$urlEncoded'>$htmlEscaped</a>";
        }, $tags);

        return $preparedTags;
    }

    private function getStringTags($tags) {
        $stringTags = array_map(function ($tag) {
            return $tag['tag'];
        }, $tags);

        return $stringTags;
    }
}
