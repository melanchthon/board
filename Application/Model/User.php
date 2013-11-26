<?php
class Model_User extends Core_Model
{ 
	
	private $error = array();
	
	public function createUser(Core_User $user)
	{
		$DBH = Core_DbConnection::getInstance();
		$user->salt = $this->generateString();
		$user->pass = $this->generateHash($user->salt,$user->pass);
		$user->token = $this->generateString();
		$user->ip = $_SERVER['REMOTE_ADDR'];
		$STH = $DBH->prepare("INSERT INTO user(name, pass, salt, token, ip) 
							  VALUES (:name, :pass, :salt, :token, :ip)");
		$STH->execute(array(
		':name'=>$user->name,
		':pass'=>$user->pass,
		':salt'=>$user->salt,
		':token'=>$user->token,
		':ip'=>$user->ip,));
		return $user;
	}
	
	public function authenticate(Core_User $user)
	{
		
		$captcha = new Core_Captcha();
		
		$userData = $this->getUserIfExists($user->name); //chek if user with same name exists;
		if(!$userData){
			$this->error[] = "Нет пользователя с таким именем";
			return false;
			
		}

		if(!$this->checkPass($user->pass,$userData->pass,$userData->salt)){
			$this->error[] ="Неверный пароль";
			return false;
		}
		
		//if captcha is required validate captcha string
		if($captcha->isCaptchaRequired() && !$captcha->chekCaptcha($user->captcha)){
			$this->error[] = 'Неверный код подтверждения.';
			return false;
		}
		
		//if honeypot field is no empty, return error
		if (!empty($user->honeypot)){
			$error[] = 'Извините, произошла ошибка, попробуйте заполнить форму ёще раз.';
			return false;
		}
		
		return $userData;
	}
	
	public function cookiesAuth($name,$token)
	{
		//if there are authorization cookies,validate them. 
		$userData = $this->getUserIfExists($name);//chek, if user with same name exists;
		if(!$userData){
			return false;
		}
		//chek unique token for this user
		if(!$this->checkToken($userData->token,$token)){
			return false;
		}
		
		return $userData;
	}
	
	private function generateString()
	{
		$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n',
						'o','p','q','r','s','t','u','v','w','x','y','z','0','1',
						'2','3','4','5','6','7','8','9');
		$length = mt_rand(20,30);
		$str='';
		for($i=0;$i<$length;$i++){
			$str .= $letters[array_rand($letters)];
		}
		return $str;	
	}
	
	private function generateHash($salt, $pass)
	{
		$hash = md5($salt.$pass);
		return $hash;
	}
	
	public function getUserIfExists($name)
	{
		//get user name and chek if user with the same name exists.
		//if exists return this user information, else return false
		$DBH = Core_DbConnection::getInstance();
		$STH = $DBH->prepare('SELECT * FROM user WHERE name = :name');
		$STH->bindValue(':name',$name);
		$STH->execute();
		$userData = $STH->fetchObject('Core_User');
		return $userData;
	}
	
	public function checkPass($pass,$realHash,$salt)
	{
		$hash = $this->generateHash($salt,$pass);
		if($hash == $realHash){
			return true;
		} else {
			return false;
		}
		
	}
	
	private function checkToken($realToken, $token)
	{
		if($realToken != $token ){
			return false;
		}
		return true;
	}
	
	public function validate (Core_User $user)
	{	
		$error = array();
		$csrf = new Core_CSRF();
		$captcha = new Core_Captcha();
		
		if (mb_strlen($user->name)>25){
			$error[] = "Логин не может быть длиннее 25 символов";
		}
		
		if ($this->getUserIfExists(mb_strtolower($user->name)) || $this->checkIfReserved(mb_strtolower($user->name))){
			$error[] = "Логин уже занят";
		}
		
		if (strlen($user->pass)<8){
			$error[] = 'Пароль не должен быть меньше 8 символов';
		}

		if (!$csrf->chekToken($user->csrf)){
			$error[] = 'Извините, произошла ошибка, попробуйте заполнить форму ёще раз.';
		}
		
		if($captcha->isCaptchaRequired() && !$captcha->chekCaptcha($user->captcha)){
			$error[] = 'Неверный код подтверждения.';
		}
		
		//if honeypot field is no empty, return error
		if (!empty($user->honeypot)){
			$error[] = 'Извините, произошла ошибка, попробуйте заполнить форму ёще раз.';
		}
		
		return $error;
	}
	
	private function checkIfReserved($name)
	{
		//chek if user login isn't one of reserved names
		$reservedLogins = Config::getReservedLogins();
		$isReserved = in_array($name,$reservedLogins );
		return $isReserved;
		
	}
	
	public function getErrors()
	{
		return $this->error;
	}
}