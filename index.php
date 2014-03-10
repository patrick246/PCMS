<?php
require_once 'include/class/CMS.php';

session_start();

$cms = new CMS(dirname(__FILE__));
$cms->run();