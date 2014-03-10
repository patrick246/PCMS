<?php
function __autoload($classname)
{
	// In the current directory we go one up (include) and enter the class directory
	$includeRoot = dirname(__FILE__) . '/../class/';
	$filepath = str_replace('_', DIRECTORY_SEPARATOR, $classname).'.php';
	if(!file_exists($includeRoot.$filepath))
		return false;
	require_once $includeRoot.$filepath;
}