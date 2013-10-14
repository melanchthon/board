<?php

class Config
{
	private static $dbName = 'board';
	private static $dbHost = 'localhost';
	private static $dbUser = 'root';
	private static $dbPass = 'pass@word1';
	private static $postsPerPage = 5;
		
		
	public static function getDbConfig()
	{
		$arr = array('name' => self::$dbName,
					 'host' => self::$dbHost,
					 'user' => self::$dbUser,
					 'pass' => self::$dbPass,
					);
		
		return $arr;
	}

	public static function getPostsPerPage ()
	{
		return self::$postsPerPage;
	}
	
	
	
	
}