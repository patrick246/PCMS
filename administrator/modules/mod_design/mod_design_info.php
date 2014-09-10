<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 07.09.14
 * Time: 16:27
 */

class mod_design_info implements ModuleInfo {

	public function getAuthor()
	{
		return "patrick246";
	}

	public function getName()
	{
		return "Designauswahl";
	}

	public function getVersion()
	{
		return "1.0";
	}

	public function getDefaultMethod()
	{
		return "form";
	}

	public function getDefaultParams()
	{
		return array();
	}
}