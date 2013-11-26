<?php
class Model_Comment extends Core_Model
{

	public function createComment (Core_Comment $comment)
	{
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("INSERT INTO comment(create_time, post_id, content, name) 
							  VALUES (:createTime, :postId, :content, :name)");
		$STH->execute(array(
		':createTime'=>$comment->createTime,
		':postId'=>$comment->postId,
		':content'=>$comment->content,
		':name'=>$comment->name,));
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
		$comments=array();
		$postsIds = $this->getPostsIds($posts);//id постов на текущей странице
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare("SELECT * FROM comment WHERE post_id = :id ORDER BY create_time DESC LIMIT :commentsOnMainPage");
		
		foreach ($postsIds as $id){
			$STH->bindValue(':id',$id,PDO::PARAM_INT);
			$STH->bindValue(':commentsOnMainPage',Config::getCommentsOnMainPage(),PDO::PARAM_INT);
			$STH->execute();
			$postComments = $STH->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Core_Comment');
			foreach ($postComments as $c){
				$comments[] = $c;
			}
		}

		return $comments;
	}
	
	public function validate (Core_Comment $comment)
	{	
		$error = array();
		$csrf = new Core_CSRF();
		$captcha = new Core_Captcha();
		
		if (empty($comment->content)){
			$error[] = "Комментарий не должен быть пустым";
		}
		
		//chek if isset csrf token
		if (!$csrf->chekToken($comment->csrf)){
			$error[] = 'Извините, произошла ошибка, попробуйте заполнить форму ёще раз.';
		}
		//if captcha is required validate captcha string
		if($captcha->isCaptchaRequired() && !$captcha->chekCaptcha($comment->captcha)){
			$error[] = 'Неверный код подтверждения.';
		}
		
		//if honeypot field is no empty, return error
		if (!empty($comment->honeypot)){
			$error[] = 'Извините, произошла ошибка, попробуйте заполнить форму ёще раз.';
			return false;
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