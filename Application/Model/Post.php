<?php
class Model_Post extends Core_Model
{

	
	public function getPagePosts ($firstPost = 0,$postsPerPage = 0)
	{
		$DBH = Core_DbConnection::getInstance();
		//получаю все записи на странице и количество комментариев к ним:
		$STH = $DBH->prepare("SELECT * FROM post 
							ORDER BY bumped DESC 
							LIMIT :firstPost, :postsPerPage");
		$STH->bindValue(":firstPost", $firstPost, PDO::PARAM_INT);
		$STH->bindValue(":postsPerPage", $postsPerPage, PDO::PARAM_INT);
		$STH->execute();
		$posts = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Post');
		return $posts;
	}

	public function createPost (Core_Post $post)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO post(create_time, title, content, bumped, name) VALUES (:createTime, :title, :content, :bumped, :name)");
		$STH->execute((array)$post);
	}
	
	public function getThreadPost($thread)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare('SELECT * FROM post WHERE id= :thread');
		$STH->bindValue(':thread', $thread, PDO::PARAM_INT);
		$STH->execute();
		$post = $STH->fetchObject('Core_Post');
		return $post;
	}
	
	public function getPostsCount ()
	{
		$DBH = Core_DbConnection::getInstance();
		$postsNum = $DBH->query('SELECT COUNT(*) FROM post')->fetch(PDO::FETCH_NUM);
		return $postsNum[0];
	}
	
	public function validate (Core_Post $post)
	{
		$error = array();
		
		if (empty($post->title)){
			$error[] = "Заголовок не должен быть пустым";
		}
		
		if (empty($post->content)){
			$error[] = "Пост не должен быть пустым";
		}
		
		return $error;
	}
	
	public function bumpThread ($id,$time){
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("UPDATE post SET bumped = :bumped WHERE id = :id");
		$STH->bindValue(':bumped', $time, PDO::PARAM_INT);
		$STH->bindValue(':id', $id, PDO::PARAM_INT);
		$STH->execute();
		$STH = $DBH->prepare("UPDATE post SET c_number = c_number+1 WHERE id = :id");
		$STH->bindValue(':id', $id, PDO::PARAM_INT);
		$STH->execute();
	}
	
}