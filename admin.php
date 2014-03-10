<?php
require_once 'include/class/AdminCMS.php';

session_start();

$cms = new AdminCMS(dirname(__FILE__));
$cms->run();