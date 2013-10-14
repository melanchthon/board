<?php
class Model_Post extends Core_Model
{
	public function getAllPosts()
	{
		$DBH = Core_DbConnection ::getInstance();
		$posts = $DBH->query("SELECT * FROM post ORDER BY id DESC")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Post');
		return $posts;
	}
	
	public function getPagePosts ($firstPost = 0,$postsPerPage = 0)
	{
		$DBH = Core_DbConnection::getInstance();
		$posts = $DBH->query("SELECT * FROM post LIMIT {$firstPost},{$postsPerPage}")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Post');
		return $posts;
	}

	public function createPost (Core_Post $post)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO post(create_time, title, content) VALUES (:createTime, :title, :content)");
		$STH->execute((array)$post);
	}
	
	public function getThreadPost($thread)
	{
		$DBH = Core_DbConnection::getInstance();
		$post = $DBH->query("SELECT * FROM post WHERE id={$thread}")->fetchObject('Core_Post');
		return $post;
	}
	
	public function getPostsCount ()
	{
		$DBH = Core_DbConnection::getInstance();
		$postsNum = $DBH->query('SELECT COUNT(*) FROM post')->fetch(PDO::FETCH_NUM);
		return $postsNum[0];
	}
	
}