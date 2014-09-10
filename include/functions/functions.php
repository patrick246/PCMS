<?php
/**
 * This functions loads all files inside the functions folder
 * @param CMS $app
 */
function loadAllFunctions(&$app)
{
	$files = scandir(PATH_SUBDIR . 'include/functions/');
	$files = array_diff($files, array('.', '..'));
	foreach($files as $file)
	{
		if(is_dir($file)) continue;
		if(preg_match('/\.php/i', $file))
		{
			require_once $file;
		}
	}
}