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
		$STH = $DBH->prepare("INSERT INTO user(name, pass, salt, token) 
							  VALUES (:name, :pass, :salt, :token)");
		//$STH->execute((array)$user);
		$STH->bindValue(":name",$user->name);
		$STH->bindValue(":pass",$user->pass);
		$STH->bindValue(":salt",$user->salt);
		$STH->bindValue(":token",$user->token);
		$STH->execute();
	}
	
	public function authenticate(Core_User $user)
	{
		
		$userData = $this->userExists($user->name);
		if(!$userData){
			$this->error[] = "Нет пользователя с таким именем";
			return false;
		}
		
		
		if(!$this->checkPass($user->pass,$userData->pass,$userData->salt)){
			$this->error[] ="Неверный пароль";
			return false;
		}
		
		return $userData;
	}
	
	public function cookiesAuth($name,$token)
	{
		$userData = $this->userExists($name);
		if(!$userData){
			return false;
		}
		
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
	
	public function userExists($name)
	{
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
		
		if (strlen($user->name)<5){
			$error[] = "Логин не может быть меньше 5 символов";
		}
		
		if ($this->userExists($user->name)){
			$error[] = "Логин уже занят";
		}
		
		if (strlen($user->pass)<8){
			$error[] = 'Пароль не должен быть меньше 8 символов';
		}
		if (!preg_match('/[0-9]/',$user->pass)){
			$error[] = "Пароль должен содержать буквы и цифры";
		}

		return $error;
	}
	
	public function getErrors()
	{
		return $this->error;
	}
}