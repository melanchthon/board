<?php
class Model_Comment extends Core_Model
{
	public function getAllComments()
	{
		$db = Core_DbConnection ::getInstance();
		$comments = $db->query("SELECT * FROM comment")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	
	}
}