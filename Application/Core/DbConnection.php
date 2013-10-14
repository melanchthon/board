<?php
class Core_DbConnection 
{
	private static $instance=null;
	
	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {} 
	
	static public function getInstance()
	{
		$config = Config::getDbConfig();
		if (!self::$instance) {
			self::$instance = new PDO("mysql:host={$config['host']};dbname={$config['name']}",$config['user'],$config['pass']);
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		return self::$instance;
	}

}
