<?php
class Controller_Post extends Core_Controller
{
	
	public function actionCreate ()
	{
		$post = new Core_Post();
		$this->view = new Core_View();
		$this->model = new Model_Post();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (!empty($_POST['title'])){
				$post->title = trim($_POST['title']);
			}
			if (!empty($_POST['content'])){
				$post->content = trim($_POST['content']);
			}
			$post->createTime=time();

			$this->model->createPost($post);
			header('Location: ../');
		}
		$this->view->render('View_Main.php', 'View_PostCreate.php');
	}
}