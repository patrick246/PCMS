<?php
require_once 'include/class/CMS.php';

session_start();

define('URL_SUBDIR', dirname($_SERVER['PHP_SELF']) . '/');
define('PATH_SUBDIR', dirname(__FILE__) . '/');
define('_EXEC', true);

$cms = new CMS(dirname(__FILE__));
$cms->run();