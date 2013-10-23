<?php
class Core_Profiler
{
	private $dbTime = array();
	private  $query = array();
	private  $rows = array();
	private  $scriptTime;

	
	public function addQuery($start,$end,$query,$rows)
	{
		$this->dbTime[] =  round(1000*($end - $start), 4);//время выполнения запроса к бд
		$this->query[] = $query;//строка запроса
		$this->rows[] = $rows;//количество строк затронутых запросом
	}
	
	public function setScriptTime($start,$end)
	{
		$this->scriptTime = round(1000*($end - $start), 4); //время роботы скрипта
	}
	
	public  function printTable () 
	{
		
		echo "<table>";
		
		for ($i=0;$i<count($this->query);$i++){
			echo "<tr>";
			echo "<td>".$this->dbTime[$i]." ms.<td/>";
			echo "<td>".$this->rows[$i]."rows</td>";
			echo "<td>".$this->query[$i]."</td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "Total DB:".array_sum($this->dbTime)."ms, script:".$this->scriptTime."ms. Total memory:".memory_get_usage(true).
			" Peak memory:".memory_get_peak_usage(true);
	}
}