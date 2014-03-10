<?php
class default_info implements DesignInfo
{
	public function getTemplateFile()
	{
		return "default.tpl.php";
	}
	
	public function getPluginBoxes()
	{
		return array();
	}
	
	public function getErrorTemplateFile()
	{
		echo "HEY";
		return "error.tpl.php";
	}
}