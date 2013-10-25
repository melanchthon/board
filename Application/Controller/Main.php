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
		$pagesCount = $postsCount/$postsPerPage;//количество постов на странице
		$currentPage = $this->getCurrentPage();//номер текущей страницы
		
		$firstPost = $currentPage*$postsPerPage;
		
		$posts = $this->post->getPagePosts($firstPost, $postsPerPage);
		if(empty($posts)){
			$this->getBlankPage();
			die;
		}
		$comments = $this->comment->getPageComments($posts); //получаю массив всех комментариев для текущей страницы
		$this->view->render('View_Main.php', 'View_Template.php',array(
		'posts'=>$posts,
		'comments'=>$comments,
		'pagesCount'=>$pagesCount,
		'currentPage'=>$currentPage,
		));
		
	}
	
	private function getCurrentPage()
	{
		if(isset($_GET['page'])){
			return $_GET['page'];
		} else {
			return 0;
		}
	}
	
	private function getblankPage()
	{
		$this->view->render('View_Blank.php', 'View_Template.php');
	}
	
}