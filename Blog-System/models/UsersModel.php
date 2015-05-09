<?php

class UsersModel extends BaseModel {
    public function register($username, $password) {
        $user = R::dispense('users');
        $user['username'] = $username;
        $user['password'] = password_hash($password, PASSWORD_DEFAULT);
        $user['isAdmin'] = false;
        $userId = R::store($user);

        return $userId;
    }

    public function login($username, $password) {
        $user = R::findOne('users', 'username = ?', [$username]);
        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        return $user;
    }

    public function isUsernameValid($username) {
        $user = R::findOne('users', 'username = ?', [$username]);
        if (!$user) {
            return true;
        }

        return false;
    }

    public function changePassword($username, $password, $newPassword) {
        $user = R::findOne('users', 'username = ?', [$username]);
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        $user['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        $userId = R::store($user);
        return $userId > 0;
    }
}
