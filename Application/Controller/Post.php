<?php
class Controller_Post extends Core_Controller
{
	
	private $error;
	
	public function actionCreate ()
	{
		$post = new Core_Post();
		$this->view = new Core_View();
		$this->model = new Model_Post();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$post->title = trim($_POST['title']);
			$post->content = trim($_POST['content']);
			$post->createTime=$post->bumped=time();
			$post->name = (!empty($_POST['name']))? trim($_POST['name']) : Config::getDefaultName();
			$this->error = $this->model->validate($post);
			if (empty($this->error)){
				$this->model->createPost($post);
				header('Location: ../');
			} else {
				$this->view->render('View_PostCreate.php','View_Template.php',array('error'=>$this->error));
			}
		}
		$this->view->render('View_PostCreate.php','View_Template.php');
	}
	
	
}