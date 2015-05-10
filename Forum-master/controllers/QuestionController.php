<?php

class QuestionController extends BaseController {
    protected $post;

    public function add()
    {
        $this->authorize();
    	$question = new QuestionModel();
    	if(isset($_POST['Submit'])) {
    		$Title = htmlentities(trim($_POST['title']));
    		$Text = htmlentities(trim($_POST['text']));
    		$Category = htmlentities(trim($_POST['category']));
    		$Tags = htmlentities(trim($_POST['tags']));
    		$question->add($Title, $Text, $Category, $Tags, $_SESSION['user']['id']);
    		//TODO : Add validation
            $this->redirect("home", "index");
    	}
    }

    public function preview($id)
    {
        $question = new QuestionModel();
        $this->authorize();
        $post_id = (int)$id;
        if(!$post_id) {
            $this->redirect("home", "index");
        }
        $this->post = $question->getById($post_id);
    }
}

