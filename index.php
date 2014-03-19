<?php
require_once 'include/class/CMS.php';

session_start();

define('SUBDIR', substr(dirname($_SERVER['PHP_SELF']), 1));

$cms = new CMS(dirname(__FILE__));
$cms->run();