<?php
class Core_Auth 
{
	/*public $userName;
	
	private function __construct($name)
	{
		$this->userName = $name;
	}*/

	
	public function login($user,$remember = false)
	{
		$_SESSION['name'] = $user->name;
		if ($remember == true){
			setcookie('name',$user->name,time()+7*24*60*60,'/');
			setcookie('token',$user->token,time()+7*24*60*60,'/');
		}
	}
	
	public function logout()
	{
		session_destroy();
		setcookie('name',NULL,time()-3600,'/');
		setcookie('token',NULL,time()-3600,'/');
		
	}
	
	public function isLogged()
	{
		if (isset($_SESSION['name'])){
			return true;
		} else if (isset ($_COOKIE['name']) || isset($_COOKIE['token'])) {
			$this->cookiesAuth();
			return true;
		} else {
			return false;
		}
	}

	
	private function cookiesAuth()
	{
		$model = new Model_User();
		$name = $_COOKIE['name'];
		$token = $_COOKIE['token'];
		$user = $model->cookiesAuth($name,$token);
		if(!$user){
			return false;
		}
		$this->login($user);
	}
	
	public function getName()
	{
		if (isset($_SESSION['name'])){
			return $_SESSION['name'];
		}
		return Config::getDefaultName();
	}
}