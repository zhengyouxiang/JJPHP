<?php
!defined("JJPATH") && define("JJPATH",dirname(__FILE__));
header("Content-Type:application/json; charset=utf-8");   
header("Cache-Control: no-store");
require_once('core/JJPHP.php'); 
JJPHP::start();