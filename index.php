<?php
ob_start("ob_gzhandler");
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("UTC");
set_include_path(get_include_path() . PATH_SEPARATOR . "./lib");
chdir("lib");
 
require_once 'Core/Autoloader.php';
new Core\Autoloader(["Zend","Skoch"]);

new Core\Controller();

ob_end_flush();                                                                        