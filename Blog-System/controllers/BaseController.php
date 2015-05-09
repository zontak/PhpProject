<?php

abstract class BaseController {
    protected $controllerName;
    protected $actionName;
    protected $layout = DEFAULT_LAYOUT;
    protected $viewBag = [];
    protected $isViewRendered = false;
    protected $postsModel;
    protected $sidebarController;

    public function __construct($controller, $action) {
        $this->controllerName = $controller;
        $this->actionName = $action;
        $this->postsModel = new PostsModel();
        $this->sidebarController = new SidebarController($this->postsModel);
        $this->onInit();
    }

    public function __get($name) {
        if (isset($this->viewBag[$name])) {
            return $this->viewBag[$name];
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    public function __set($name, $value) {
        $this->viewBag[$name] = $value;
    }

    public function renderView($viewName = null, $includeLayout = true) {
        if ($this->isViewRendered) {
            return;
        }

        if (!$viewName) {
            $viewName = $this->actionName;
        }

        if ($includeLayout) {
            include_once('views/layouts/' . $this->layout . '/header.php');
        }

        include_once('views/' . $this->controllerName . '/' . $viewName . '.php');

        if ($includeLayout) {
            include_once('views/layouts/' . $this->layout . '/footer.php');
        }

        $this->isViewRendered = true;
    }

    protected function onInit() {
        $this->title = 'Tr00peR\'s Blog';
    }

    protected function redirect($controller = null, $action = null, $params = []) {
        if (!$controller) {
            $controller = $this->controllerName;
        }

        $url = "/$controller/$action";
        $paramsUrlEncoded = array_map('urlencode', $params);
        $paramsJoined = implode('/', $paramsUrlEncoded);
        if ($paramsJoined) {
            $url = $url . '/' . $paramsJoined;
        }

        header("Location: $url");
        die();
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    protected function addMessage($msgText, $type) {
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }

        $_SESSION['messages'][$msgText] = $type;
    }

    protected function addErrorMessage($msgText) {
        $this->addMessage($msgText, 'danger');
    }

    protected function addSuccessMessage($msgText) {
        $this->addMessage($msgText, 'success');
    }

    protected function isLoggedIn() {
        return isset($_SESSION['username']) && isset($_SESSION['userId']);
    }

    protected function authorize() {
        if (!$this->isLoggedIn()) {
            $this->addErrorMessage('You must be logged in.');
            $this->redirect('users', 'login');
        }
    }

    protected function isAdmin() {
        return $this->isLoggedIn() && isset($_SESSION['isAdmin']);
    }

    protected function authorizeAdmin() {
        $this->authorize();
        if (!$this->isAdmin()) {
            $this->addErrorMessage('This page is for administrators only.');
            $this->redirect(DEFAULT_CONTROLLER);
        }
    }

    protected function setFormToken() {
        if (!isset($_POST['form-token'])) {
            $_SESSION['form-token'] = uniqid(mt_rand(), true);
        }
    }
}
