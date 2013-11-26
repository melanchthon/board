<?php
class Controller_User extends Core_Controller
{
	

	public function actionCreate()
	{
		$user = new Core_User();
		$this->model = new Model_User();
		$this->view = new Core_View();	
		$this->isCaptchaRequired();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->getPost($user);
			$error = $this->model->validate($user);
			if (empty($error)){
				$userData = $this->model->createUser($user);
				$authManager = new Core_Auth();
				$authManager->login($userData,$user->remember);
				header("Location:".Config::getbasePath().'/user/succes');
			} else {	
				$this->view->render('View_UserCreate.php','View_Template.php', array('error'=>$error,
																					'name'=>$user->name,
																					'pass'=>$user->pass));																
			}
			
		}
	
	$this->view->render('View_UserCreate.php','View_Template.php');
	}
	
	public function actionLogin()
	{	
		$user = new Core_User();
		$this->model = new Model_User();
		$this->view = new Core_View();
		$this->isCaptchaRequired();
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->getPost($user);
			$userData = $this->model->authenticate($user);//get $user oject if authentication is succes
			if ($userData){
				$authManager = new Core_Auth();
				$authManager->login($userData,$user->remember);
				header("Location:".Config::getbasePath());
			} else {
				//if login attempt is unsuccesfull, display login form again with error messages
				$error = $this->model->getErrors();
				$this->setFailsCount(); //increase counter of failed  login attempts
				$this->view->render('View_UserLogin.php','View_Template.php', array('error'=>$error,
																					'name'=>$user->name,
																					'pass'=>$user->pass));
			}	
		}
		$this->view->render('View_UserLogin.php','View_Template.php');
	}
	
	public function actionLogout()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$authManager = new Core_Auth();
			$authManager->logout();
			header("Location:".Config::getbasePath());	
			}
		return false;
	}
	
	public function actionSucces()
	{
		$this->view = new Core_View();
		$this->view->render('View_registrationSucces.php','View_Template.php');
	}

	
	public function getFailsCount()
	{
		//return number of failed login attempts from this ip;
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION[$ip])){
			return $_SESSION[$ip]['failsCounter'];
		}
	}
	
	public function setFailsCount()
	{
		//increase number of failed attempts by 1 and store it in the session
		$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SESSION[$ip])){
			$_SESSION[$ip]['failsCounter'] += 1;
		} else {
			$_SESSION[$ip]['failsCounter'] = 1;
		}
	}
	
	private function isCaptchaRequired()
	{
		//if  amount of failed login attempts is more then 3, captcha is required
		$auth = new Core_Auth();
		$capthca = new Core_Captcha();
		if($this->getFailsCount() >= 3){
			$capthca->requireCaptcha();
		} else {
			$capthca->disableCaptcha();
		}
	}	
	
}