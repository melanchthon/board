<?php
class Model_Post extends Core_Model
{
	public function getAllPosts()
	{
		$db = Core_DbConnection ::getInstance();
		$posts = $db->query("SELECT * FROM post ORDER BY id DESC")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Post');
		return $posts;
	}


}