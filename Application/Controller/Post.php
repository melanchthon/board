<?php
class Controller_Post extends Core_Controller
{
	
	public function actionCreate ()
	{
		
		$post = new Core_Post();
		$this->view = new Core_View();
		$this->model = new Model_Post();
		$this->isCaptchaRequired();
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			$this->getPost($post);
			$post->createTime=$post->bumped=date('Y-m-d H:i:s');
			$this->error = $this->model->validate($post);
			
			if (empty($this->error)){
				$this->model->createPost($post);
				header('Location: ../');
			} else {
				$this->view->render('View_PostCreate.php','View_Template.php',array('error'=>$this->error, 'title'=>$post->title, 'content'=>$post->content));
			}
		}
		$this->view->render('View_PostCreate.php','View_Template.php');
	}
	
	private function isCaptchaRequired()
	{
		$auth = new Core_Auth();
		$capthca = new Core_Captcha();
		if(!$auth->isLogged()){
			$capthca->requireCaptcha();
		} else {
			$capthca->disableCaptcha();
		}
	}	
	
}