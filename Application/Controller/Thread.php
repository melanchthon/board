<?php
class Controller_Thread extends Core_Controller
{
	private $post;
	private $comment;
	
	public function actionIndex ()
	{
		$this->view = new Core_View();
		$this->post = new Model_Post();
		$this->comment = new Model_Comment();
		$thread = $_GET['thread'];
		
		$threadPost = $this->post->getThreadPost($thread);
		$comments = $this->comment->getThreadComments($thread);
		
		$this->view->render('View_Thread.php', 'View_Template.php',array(
		'post'=>$threadPost,
		'comments'=>$comments,
		));
	}

}