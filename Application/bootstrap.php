<?php
session_start();

$start = microtime(true);//время начала роботы скрипта
require_once('Core/Autoload.php');
spl_autoload_register(array('Core_Autoload', 'loadClass'));

$profiler = new Core_Profiler();
$pdo = Core_DbConnection::getInstance();
if (Config::isProfilerEnabled()){
	$pdo->setProfiler($profiler);
}


$frontController = new Core_FrontController();
$frontController->run();
$end = microtime(true);//время конца роботы скрипта
$profiler->setScriptTime($start,$end);
if (Config::isProfilerEnabled()){
	echo '<hr/>';
	$profiler->printTable();
}