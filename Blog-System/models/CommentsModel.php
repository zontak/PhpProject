<?php

class CommentsModel extends BaseModel {
    public function add($postId, $text, $username, $userId = null) {
        $comment = R::dispense('comments');
        $comment['post_id'] = $postId;
        $comment['text'] = $text;
        $comment['date'] = R::isoDateTime();
        $comment['username'] = $username;
        $comment['user_id'] = $userId;
        $commentId = R::store($comment);

        return $commentId;
    }

    public function delete($commentId) {
        $comment = R::load('comments', $commentId);
        R::trash($comment);
    }
}
