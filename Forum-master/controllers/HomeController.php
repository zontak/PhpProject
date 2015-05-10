<?php

class HomeController extends BaseController {

	private $questionModel;
    protected $posts;

    public function index()
    {
    	$this->questionModel = new QuestionModel();
        $this->posts = $this->questionModel->getAll();
    }
}
