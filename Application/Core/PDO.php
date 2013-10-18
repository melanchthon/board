<?php
class Core_PDO extends PDO
{
	
	public function __construct($dsn,$username=null,$password=null,$driverOptions=array())
	{
		parent::__construct($dsn,$username,$password,$driverOptions);
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS,array('Core_PDOStatement',array($this)));
		
	}
	
	public function query($str)
	{
		Core_Profiler::setStart();
		$result = parent::query($str);
		Core_Profiler::setEnd();
		Core_Profiler::setQuery($str);
		Core_Profiler::setRows($result->rowCount());
		return $result;
	}
}