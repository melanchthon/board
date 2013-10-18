<?php
class Model_Comment extends Core_Model
{
	
	
	public function createComment (Core_Comment $comment)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO comment(create_time, post_id, content) VALUES (:createTime, :postId, :content)");
		$STH->execute((array)$comment);
	}
	
	public function getThreadComments ($thread)
	{
		$DBH  = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("SELECT  * FROM comment WHERE post_id= :thread");
		$STH->bindParam(':thread', $thread);
		$STH->execute();
		$comments = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
	public function getPageComments($firstPostId = 0, $lastPostId = 0)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("SELECT  * FROM comment WHERE post_id<= :firstPostId AND post_id>=:lastPostId");
		$STH->bindParam(":firstPostId",$firstPostId);
		$STH->bindParam(":lastPostId",$lastPostId);
		$STH->execute();
		$comments = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
}