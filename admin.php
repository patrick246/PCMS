<?php
require_once 'include/class/AdminCMS.php';

session_start();

define('URL_SUBDIR', dirname($_SERVER['PHP_SELF']) . '/');
define('PATH_SUBDIR', dirname(__FILE__) . '/');

$cms = new AdminCMS(dirname(__FILE__));
$cms->run();