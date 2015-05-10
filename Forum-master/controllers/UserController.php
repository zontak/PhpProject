<?php

 class UserController extends BaseController {

    public function login() {
        $user = new UserModel();
        if(isset($_POST['Submit'])) {
            $Email = htmlentities(trim($_POST['Email']));
            $Password = md5(trim($_POST['Password']));
            $user = $user->userValidation($Email,$Password);
            if($user) {
                $_SESSION['user'] = $user;
                $this->redirect('Home', 'index');
            }
            else{
                //TODO : ERROR
            }

    }
}

    public function logout()
    {
        session_destroy();
        $this->redirect('Home', 'index');
    }
     public function register()
    {
    	$user = new UserModel();
    	if(isset($_POST['Submit'])) {
    		$Email = htmlentities(trim($_POST['Email']));
    		$Password = md5(trim($_POST['Password']));
    		if(!$user->exist($Email)) {
    			$user->create($Email, $Password);
    		}
    		else{
    			//TODO : ERROR
    		}
    	}
    }
}
