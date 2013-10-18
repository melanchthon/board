<?php
require_once('Core/Autoload.php');
spl_autoload_register(array('Core_Autoload', 'loadClass'));

Core_Profiler::setScriptStart();//время начала выполнения скрипта
$frontController = new Core_FrontController();
$frontController->run();//время конца выполнения скрипта
Core_Profiler::setScriptEnd();
if (Config::isProfilerEnabled()){
	echo '<hr/>';
	Core_Profiler::printTable();
}