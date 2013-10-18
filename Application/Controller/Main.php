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
		$firstPostId = $posts[0]->id; //узнаю id первого поста на текущей странице
		$lastPostId = $posts[$postsPerPage-1]->id; //узнаю id  последнего поста на текущей странице
		$comments = $this->comment->getPageComments($firstPostId, $lastPostId); //получаю массив всех комментариев длятекущей страницы
		$this->view->render('View_Main.php', 'View_Template.php',array(
		'posts'=>$posts,
		'comments'=>$comments,
		'pagesCount'=>$pagesCount,
		'currentPage'=>$currentPage,
		));
	}
	
	
}