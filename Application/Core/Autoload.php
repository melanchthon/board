<?php
class Core_Autoload
{
	public static function loadClass($className)
	{
		$path = explode("_",$className); 
		$path = "Application/".implode('/',$path).'.php';
		if(file_exists($path)) {
			require_once($path);	
		}
	}
}