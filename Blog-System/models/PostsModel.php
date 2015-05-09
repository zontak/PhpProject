<?php

class PostsModel extends BaseModel {
    public function create($title, $text, $tags) {
        $post = R::dispense('posts');
        $post['title'] = $title;
        $post['text'] = $text;
        $post['date'] = R::isoDateTime();
        $post['visits'] = 0;
        $post['username'] = $_SESSION['username'];
        $post['user_id'] = $_SESSION['userId'];
        $post->sharedTagsList = $this->processTags($tags);
        $postId = R::store($post);

        return $postId;
    }

    public function getById($postId) {
        $post = R::load('posts', $postId);
        if ($post['id'] === 0) {
            return null;
        }

        $post->visits++;
        R::store($post);

        return $post;
    }

    public function getLast($page = 0) {
        $post = R::findOne('posts', "ORDER BY date DESC LIMIT $page, 1");
        return $post;
    }

    public function getByTag($tag) {
        $posts = R::getAll('SELECT p.id, p.title, p.date, p.username FROM posts p ' .
            'JOIN posts_tags ON p.id = posts_tags.posts_id '.
            'JOIN tags ON tags.id = posts_tags.tags_id WHERE tags.tag = ?', [$tag]);

        return $posts;
    }

    public function getByDate($year, $month = null) {
        $sql = 'SELECT p.id, p.title, p.date, p.username FROM POSTS p WHERE YEAR(p.date) = ?';
        if ($month) {
            $posts = R::getAll("$sql AND MONTH(p.date) = ?" , [$year, $month]);
        } else {
            $posts = R::getAll($sql, [$year]);
        }

        return $posts;
    }

    public function getBySearchData($words) {
        $results = [];
        foreach ($words as $word) {
            $posts = R::getAll('SELECT DISTINCT p.id, p.title, p.date, p.username FROM posts p ' .
                'JOIN posts_tags ON p.id = posts_tags.posts_id JOIN tags ON tags.id = posts_tags.tags_id ' .
                'WHERE tags.tag LIKE ? OR p.title LIKE ?', ["%$word%", "%$word%"]);
            $results = array_merge($results, $posts);
        }

        return $results;
    }

    public function getPostDates() {
        $posts = R::getAll('SELECT MONTH(p.date) AS month, MONTHNAME(p.date) AS monthname, ' .
            'YEAR(p.date) AS year FROM posts p '.
            'GROUP BY CONCAT(YEAR(p.date), MONTH(p.date)) DESC');

        return $posts;
    }

    public function edit($postId, $title, $text, $tags) {
        $post = R::load('posts', $postId);
        if ($post['id'] === 0) {
            return null;
        }

        $post['title'] = $title;
        $post['text'] = $text;
        $post->sharedTagsList = $this->processTags($tags);
        R::store($post);

        return $post;
    }

    public function delete($postId) {
        $post = R::load('posts', $postId);
        R::trash($post);
    }

    public function getMostPopularTags($tagCount = 5) {
        $tags = R::getAll('SELECT tags.tag FROM tags ' .
            'JOIN posts_tags ON tags.id = posts_tags.tags_id GROUP BY tags.tag '.
            'ORDER BY COUNT(posts_tags.tags_id) DESC LIMIT ?', [$tagCount]);

        return $tags;
    }

    public function getComments($postId) {
        $comments = R::find('comments', 'post_id = ?', [$postId]);
        return $comments;
    }

    public function count() {
        $count = R::count('posts');
        return $count;
    }

    private function processTags($tagList) {
        $tags = [];
        foreach ($tagList as $tagName) {
            $tagName = str_replace('/', '', $tagName);
            $tag = R::findOne('tags', 'tag = ?', [$tagName]);
            if (!$tag) {
                $tag = R::dispense('tags');
                $tag['tag'] = $tagName;
                R::store($tag);
            }

            $tags[] = $tag;
        }

        return $tags;
    }
}
