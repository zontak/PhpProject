<?php

class CommentsController extends BaseController {
    const MIN_COMMENT_LENGTH = 2;
    const MIN_NAME_LENGTH = 2;

    private $commentsModel;

    protected function onInit() {
        $this->commentsModel = new CommentsModel();
    }

    public function index() {
        $this->redirect(DEFAULT_CONTROLLER);
    }

    public function add($postId) {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid comment data.');
        } else {
            $comment = trim($_POST['comment']);
            $username = $this->isLoggedIn() ? $_SESSION['username'] : trim($_POST['username']);
            $userId = $this->isLoggedIn() ? $_SESSION['userId'] : null;
            if (strlen($comment) < self::MIN_COMMENT_LENGTH) {
                $this->addErrorMessage('The comment must be at least ' . self::MIN_COMMENT_LENGTH . ' characters long.');
            } else if (strlen($username) < self::MIN_NAME_LENGTH) {
                $this->addErrorMessage('The name must be at least ' . self::MIN_NAME_LENGTH . ' characters long.');
            } else if (!$this->commentsModel->add($postId, $comment, $username, $userId)) {
                $this->addErrorMessage('Error in adding comment.');
            }
        }

        $this->redirect('posts', 'view', [$postId]);
    }

    public function delete($postId, $commentId) {
        $this->authorizeAdmin();
        $this->commentsModel->delete($commentId);
        $this->addSuccessMessage('Comment deleted.');
        $this->redirect('posts', 'view', [$postId]);
    }
}
