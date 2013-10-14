<?php
class Model_Comment extends Core_Model
{
	public function getAllComments()
	{
		$db = Core_DbConnection ::getInstance();
		$comments = $db->query("SELECT * FROM comment")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
	public function createComment (Core_Comment $comment)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO comment(create_time, post_id, content) VALUES (:createTime, :postId, :content)");
		$STH->execute((array)$comment);
	}
	
	public function getThreadComments ($thread)
	{
		$DBH  = Core_DbConnection::getInstance();
		$comments = $DBH ->query("SELECT  * FROM comment WHERE post_id={$thread}")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
	public function getPageComments($firstPost = 0,$postsPerPage = 0)
	{
		$lastPost = $firstPost+$postsPerPage;
		$DBH = Core_DbConnection::getInstance();
		$comments = $DBH->query("SELECT  * FROM comment WHERE post_id>={$firstPost} AND post_id<={$lastPost}")->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
		return $comments;
	}
	
}