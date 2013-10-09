<?php
class Core_DbConnection 
{
	private static $_instance=null;
	
	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {} 
	
	static public function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new PDO("mysql:host=localhost;dbname=board",'root','pass@word1');
		}
		return self::$_instance;
	}

}
