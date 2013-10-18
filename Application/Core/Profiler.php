<?php
class Core_Profiler
{
	public static $start = array();
	public static $end = array();
	public static $query = array();
	public static $rows = array();
	public static $scriptStart;
	public static $scriptEnd;

	public static function setStart() 
	{
		//время начала выполнения запроса к бд
		self::$start[] = microtime(true);
	}
	
	public static function setEnd()
	{
		//время конца выполнения запроса к бд
		self::$end[] = microtime(true);
	}
		
	public static function setQuery($query)
	{
		//строка запроса
		self::$query[] = $query;
	}
	
	public static function setRows($num)
	{
		//количество строк, которые были затронуты в ходе выполнения  запроса
		self::$rows[] = $num;
	}
	
	public static function setScriptStart()
	{
		//время начала роботы скрипта
		self::$scriptStart = microtime(true);
	}
	
	public static function setScriptEnd()
	{
		//время конца роботы скрипта
		self::$scriptEnd = microtime(true);
	}

	public static function getTime()
	{
		//время выполнения для каждого запроса к бд.
		$time = array();
		foreach (self::$start as $key=>$value){
			$mcTime = self::$end[$key] - $value;//время в формате Unix
			
			$time[] = round(1000*$mcTime, 4); // время в миллисекундах
		}
		
		return $time;
	}
	
	public static function getScriptTime()
	{
		$time = self::$scriptEnd - self::$scriptStart;
		return round(1000*$time, 4);
	}
	
	public static function printTable () 
	{
		$time = self::getTime();
		
		echo "<table>";
		
		for ($i=0;$i<count(self::$query);$i++){
			echo "<tr>";
			echo "<td>".$time[$i]." ms.<td/>";
			echo "<td>".self::$rows[$i]."rows</td>";
			echo "<td>".self::$query[$i]."</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "Total DB:".array_sum($time)."ms, script:".self::getScriptTime()."ms. Total memory:".memory_get_usage().
			" Peak memory:".memory_get_peak_usage();
	}
}