<?php
class Model_Post extends Core_Model
{

	
	public function getPagePosts ($firstPost = 0,$postsPerPage = 0)
	{
		$DBH = Core_DbConnection::getInstance();
		//получаю все записи на странице и количество комментариев к ним:
		$STH = $DBH->prepare("SELECT post.*,COUNT(comment.id)
							AS total 
							FROM post 
							LEFT JOIN comment ON (post.id = comment.post_id) 
							GROUP BY post.id O
							RDER BY id DESC 
							LIMIT :firstPost, :postsPerPage");
		$STH->bindParam(":firstPost", $firstPost, PDO::PARAM_INT);
		$STH->bindParam(":postsPerPage", $postsPerPage, PDO::PARAM_INT);
		$STH->execute();
		$posts = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Post');
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
		$STH = $DBH->prepare('SELECT * FROM post WHERE id= :thread');
		$STH->bindParam(':thread', $thread, PDO::PARAM_INT);
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
	
}