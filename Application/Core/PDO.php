<?php
class Core_PDO extends PDO
{
	
	public $profiler;
	
	public function __construct($dsn,$username=null,$password=null,$driverOptions=array())
	{
		parent::__construct($dsn,$username,$password,$driverOptions);
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS,array('Core_PDOStatement',array($this)));
		
	}
	
	public function setProfiler($profiler)
	{
		$this->profiler = $profiler; 
	}
	
	public function query($str)
	{
		$start = microtime(true);//время начала запроса к бд
		$result = parent::query($str);
		$end = microtime(true);//время конца запроса
		$query = $str;//строка запроса
		$rows = $result->rowCount();//количество строк, затронутых запросом
		$this->profiler->addQuery($start,$end,$query,$rows);
		return $result;
	}
}