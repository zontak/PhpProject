<?php
class QuestionModel extends BaseModel
{

	protected $tableName = "posts";

	public function add($title, $text,$category,$tags, $author) {
		self::$db->query("INSERT INTO $this->tableName (title,`text`, category,tags, user_id) VALUES ('$title', '$text','$category','$tags', '$author')");
	}
	public function getAll() {
        $statement = self::$db->query("SELECT p.*, u.email as author FROM posts p LEFT JOIN users u ON (p.user_id = u.id) ORDER BY p.id DESC");
        return $statement->fetch_all(MYSQLI_ASSOC);

    }

    public function getById($id) {
        $statement = self::$db->query("SELECT p.*, u.email as author FROM posts p LEFT JOIN users u ON (p.user_id = u.id) WHERE $id = p.id LIMIT 1");
        return $statement->fetch_assoc();

    }
}
