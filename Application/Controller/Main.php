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
		$postsCount = $this->post->getPostsCount();
		$postsPerPage = Config::getPostsPerPage();
		$pagesCount = $postsCount/$postsPerPage;
		
		if(isset($_GET['page'])){
			$currentPage = $_GET['page'];
		} else {
			$currentPage = 0;
		}
		$firstPost = $currentPage*$postsPerPage;
		
		$posts = $this->post->getPagePosts($firstPost, $postsPerPage);
		$comments = $this->comment->getPageComments($firstPost, $postsPerPage);
		$this->view->render('View_Main.php', 'View_Template.php',array(
	   'posts'=>$posts,
	   'comments'=>$comments,
	   'pagesCount'=>$pagesCount,
	   'currentPage'=>$currentPage,
	   ));
	}
	
	
}