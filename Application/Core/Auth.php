<?php
class Core_Auth 
{
//this class works with cookie and session variables during authentication/authorization
	public function login($user,$remember = null)
	{
		$_SESSION['name'] = $user->name;
		
		//if "remember me" button was cheked by the user set authorization cookies, else
		//set cookies, which will be destroyed after browser closing	
		if ($remember == 'on'){
			setcookie('name',$user->name,time()+7*24*60*60,'/',NULL,NULL,TRUE);
			setcookie('token',$user->token,time()+7*24*60*60,'/',NULL,NULL,TRUE);
		} else {
			setcookie('name',$user->name,NULL,'/',NULL,NULL,TRUE);
			setcookie('token',$user->token,NULL,'/',NULL,NULL,TRUE);
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
		//chek if user is logged
		if (isset($_SESSION['name'])){
			return true;
		} else if (isset ($_COOKIE['name']) && isset($_COOKIE['token'])) {
			$this->cookiesAuth();
			return true;
		} else {
			return false;
		}
	}

	
	private function cookiesAuth()
	{
		//authentication with cookies; if cookies are set and data matches to the stored in database, 
		//authenticate user, else return false
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
		if ($this->isLogged()){
			return $_SESSION['name'];
		}
		return null;
	}
}