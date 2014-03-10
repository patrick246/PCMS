<?php
class bootstrap_info implements DesignInfo
{
	public function getTemplateFile()
	{
		return "bootstrap.tpl.php";
	}
	public function getPluginBoxes()
	{
		return array();
	}
	public function getErrorTemplateFile()
	{
		return "error.tpl.php";
	}
}