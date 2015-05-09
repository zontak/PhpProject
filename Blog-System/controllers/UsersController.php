<?php

class UsersController extends BaseController {
    const MIN_USERNAME_LENGTH = 2;
    const MIN_PASSWORD_LENGTH = 2;

    private $usersModel;

    protected function onInit() {
        $this->usersModel = new UsersModel();
    }

    public function index() {
        $this->redirect('users', 'login');
    }

    public function login() {
        $this->redirectIfLoggedIn();
        $this->setFormToken();
        $this->title = 'Login';
        if ($this->isPost()) {
            $this->loginUser();
        }
    }

    public function register() {
        $this->redirectIfLoggedIn();
        $this->setFormToken();
        $this->title = 'Registration';
        if ($this->isPost()) {
            $this->registerUser();
        }
    }

    public function changePassword() {
        $this->authorize();
        $this->setFormToken();
        $this->title = 'Change password';
        if ($this->isPost()) {
            $this->changeUserPassword();
        }
    }

    public function logout() {
        $this->authorize();
        session_unset();
        session_destroy();
        $this->redirect(DEFAULT_CONTROLLER);
    }

    private function registerUser() {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid registration.');
            return;
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirm-password']);
        if (strlen($username) < self::MIN_USERNAME_LENGTH) {
            $this->addErrorMessage('The username must be at least ' . self::MIN_USERNAME_LENGTH . ' characters long.');
            return;
        }

        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            $this->addErrorMessage('The password must be at least ' . self::MIN_PASSWORD_LENGTH . ' characters long.');
            return;
        }

        if ($password !== $confirmPassword) {
            $this->addErrorMessage('The passwords do not match.');
            return;
        }

        if (!$this->usersModel->isUsernameValid($username)) {
            $this->addErrorMessage('This username is already taken.');
            return;
        }

        $userId = $this->usersModel->register($username, $password);
        if (!$userId) {
            $this->addErrorMessage('Registration error.');
            return;
        }

        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $userId;
        $this->addSuccessMessage('Registration successful.');
        $this->redirect(DEFAULT_CONTROLLER);
    }

    private function loginUser() {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid login.');
            return;
        }

        $user = $this->usersModel->login($_POST['username'], $_POST['password']);
        if (!$user) {
            $this->addErrorMessage('Invalid login.');
            return;
        }

        $_SESSION['username'] = $user['username'];
        $_SESSION['userId'] = $user['id'];
        if ($user['isAdmin']) {
            $_SESSION['isAdmin'] = true;
        }

        $this->redirect(DEFAULT_CONTROLLER);
    }

    private function changeUserPassword() {
        if (!isset($_POST['form-token']) || $_POST['form-token'] !== $_SESSION['form-token']) {
            $this->addErrorMessage('Invalid password data.');
            return;
        }

        $password = trim($_POST['password']);
        $newPassword = trim($_POST['new-password']);
        $newPasswordConfirm = trim($_POST['new-password-confirm']);
        if (strlen($newPassword) < self::MIN_PASSWORD_LENGTH) {
            $this->addErrorMessage('The password must be at least ' . self::MIN_PASSWORD_LENGTH . ' characters long.');
            return;
        }

        if ($newPassword !== $newPasswordConfirm) {
            $this->addErrorMessage('The passwords do not match.');
            return;
        }

        if (!$this->usersModel->changePassword($_SESSION['username'], $password, $newPassword)) {
            $this->addErrorMessage('Change password error.');
            return;
        }

        $this->redirect(DEFAULT_CONTROLLER);
    }

    private function redirectIfLoggedIn() {
        if ($this->isLoggedIn()) {
            $this->redirect(DEFAULT_CONTROLLER);
        }
    }
}
