<?php
class Controller_Post extends Core_Controller
{
	
	private $error = array();
	
	public function actionCreate ()
	{
		$post = new Core_Post();
		$this->view = new Core_View();
		$this->model = new Model_Post();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$post->title = trim($_POST['title']);
			$post->content = trim($_POST['content']);
			$post->createTime=time();
			
			$this->validate($post);
			if (empty($this->error)){
				$this->model->createPost($post);
				header('Location: ../');
			} else {
				$this->view->render('View_PostCreate.php','View_Template.php',array('error'=>$this->error));
			}
		}
		$this->view->render('View_PostCreate.php','View_Template.php');
	}
	
	private function validate (Core_Post $post)
	{
		if (empty($post->title)){
			$this->error[] = "Заголовок не должен быть пустым";
		}
		
		if (empty($post->content)){
			$this->error[] = "Пост не должен быть пустым";
		}
	}
}