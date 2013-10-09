<?php
class Controller_Main extends Core_Controller
{
	private $post;
	private $comment;


	public function actionIndex ()
	{
		$this->view = new Core_View();
		$this->post = new Model_Post();
	    $this->comment = new Model_Comment();
		
		$posts = $this->post->getAllPosts();
		$comments = $this->comment->getAllComments();
		$this->view->render('View_Main.php', 'View_Template.php',array(
	   'posts'=>$posts,
	   'comments'=>$comments,
	   ));
	}
	
	
}