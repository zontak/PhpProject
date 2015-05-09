<?php

class SidebarController {
    public function __construct($postsModel) {
        $tags = $postsModel->getMostPopularTags(5);
        $this->tags = $this->getPreparedTags($tags);
        $this->dates = $postsModel->getPostDates();
    }

    private function getPreparedTags($tags) {
        $preparedTags = array_map(function ($tag) {
            $htmlEscaped = htmlspecialchars($tag['tag']);
            $urlEncoded = urlencode($tag['tag']);
            return "<a href='/posts/byTag/$urlEncoded'>$htmlEscaped</a>";
        }, $tags);

        return $preparedTags;
    }
}
