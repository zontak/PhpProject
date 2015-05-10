<?php

class UserModel extends BaseModel
{

	protected $tableName = "users";

	public function create($email, $password) {
		self::$db->query("INSERT INTO $this->tableName (email, password) VALUES ('$email', '$password')");
	}
	public function exist($email) {

		$statement = self::$db->query("SELECT id FROM $this->tableName WHERE email='$email' ");
        $count = $statement->num_rows;
        return (bool) $count;
	}
	public function userValidation ($email, $password){
		$statement = self::$db->query("SELECT id, email FROM $this->tableName WHERE email='$email' AND password='$password' LIMIT 1");
        $user = $statement->fetch_assoc();
        if(isset($user['id'])) {
        	return $user;
        }
        return false;
	}
}