<?php
require_once('Core/Autoload.php');
spl_autoload_register(array('Core_Autoload', 'loadClass'));

$frontController = new Core_FrontController();
$frontController->run();