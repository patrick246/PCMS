<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 30.08.14
 * Time: 01:35
 */
function myDir()
{
	$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	$file = $backtrace[0]['file'];
	return str_replace(PATH_SUBDIR, URL_SUBDIR , dirname($file) . '/');
}