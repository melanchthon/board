<?php
class Core_Autoload
{
	public static $_path = "";

	public static function loadClass($className)
	{
		$path = explode("_",$className); 
		self::$_path = "Application/".implode('/',$path).'.php';
		require_once(self::$_path);	
	}


}