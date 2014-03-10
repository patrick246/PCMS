<?php
class default_info implements DesignInfo
{
	public function getTemplateFile() 
	{
		return "default.tpl.php";
	}
	
	public function getErrorTemplateFile()
	{
		return "error.tpl.php";
	}
	
	public function getPluginBoxes()
	{
		return array("box_underMenu", "box_aboveMenu",
					 "box_underContent", "box_aboveContent"
				);
	}
}