<?php
require_once 'include/class/AdminCMS.php';

session_start();

define('SUBDIR', substr(dirname($_SERVER['PHP_SELF']), 1));

$cms = new AdminCMS(dirname(__FILE__));
$cms->run();