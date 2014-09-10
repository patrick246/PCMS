<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 30.08.14
 * Time: 01:30
 */

class default3_info implements DesignInfo {

	public function getTemplateFile()
	{
		return 'main.tpl.php';
	}

	public function getPluginBoxes()
	{
		return array();
	}

	public function getErrorTemplateFile()
	{
		return 'error.tpl.php';
	}
}