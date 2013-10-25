<?php
class Model_Comment extends Core_Model
{
	
	private $error;
	
	
	public function createComment (Core_Comment $comment)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO comment(create_time, post_id, content, name) 
							  VALUES (:createTime, :postId, :content, :name)");
		$STH->execute((array)$comment);
	}
	
	public function getThreadComments ($thread)
	{
		$DBH  = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("SELECT  * FROM comment WHERE post_id= :thread ORDER BY create_time ASC ");
		$STH->bindValue(':thread', $thread);
		$STH->execute();
		$comments = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
	public function getPageComments($posts)
	{
		
		$postsIds = $this->getPostsIds($posts);//id постов на текущей странице
		$DBH = Core_DbConnection::getInstance();
		$placeholder = implode(',',array_fill(0, count($postsIds), '?')); 
		$STH = $DBH->prepare("SELECT  * FROM comment WHERE post_id IN ($placeholder) GROUP BY create_time DESC");
		foreach($postsIds as $key=>$value){
			$STH->bindValue(($key+1),$value);
		}
		$STH->execute();

		$comments = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		
		
		return $comments;
	}
	
	public function validate (Core_Comment $comment)
	{	
		$error = array();
		
		if (empty($comment->content)){
			$error[] = "Комментарий не должен быть пустым";
		}
		
		return $error;
	}
	
	private function getPostsIds ($posts)
	{
		$ids = array();
		foreach($posts as $post){
			$ids[] = $post->id;
		}
		return $ids;
	}
}