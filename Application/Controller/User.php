<?php
class Controller_User extends Core_Controller
{
	

	public function actionCreate()
	{
		$user = new Core_User();
		$this->model = new Model_User();
		$this->view = new Core_View();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user->name = $_POST["name"];
			$user->pass = $_POST["pass"];
		
			$error = $this->model->validate($user);
			if (empty($error)){
				$this->model->createUser($user);
				header("Location:".Config::getbasePath()."/user/succes");
			} else {
				$this->view->render('View_UserCreate.php','View_Template.php', array('error'=>$error));
			}
			
		}
	
	$this->view->render('View_UserCreate.php','View_Template.php');
	}
	
	public function actionLogin()
	{
		$user = new Core_User();
		$this->model = new Model_User();
		$this->view = new Core_View();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$user->name = $_POST["name"];
			$user->pass = $_POST["pass"];
			$remember = ($_POST["remember"] == "yes") ? true : false;
			
			$userData = $this->model->authenticate($user);
			if ($userData){
				$authManager = new Core_Auth();
				$authManager->login($userData,$remember);
				header("Location:".Config::getbasePath());
			} else {
				$error = $this->model->getErrors();
				$this->view->render('View_UserLogin.php','View_Template.php', array('error'=>$error));
			}
			
		}
		$this->view->render('View_UserLogin.php','View_Template.php');
	}
	
	public function actionLogout()
	{
		$authManager = new Core_Auth();
		$authManager->logout();
		header("Location:".Config::getbasePath());	
	}
	
	public function actionSucces()
	{
		$this->view = new Core_View();
		$this->view->render('View_registrationSucces.php','View_Template.php');
	}
	
}