<?php
class mod_test_info implements ModuleInfo
{
	public function getName()
	{
		return "Test Module";
	}
	public function getVersion()
	{
		return "v1.0";
	}
	public function getAuthor()
	{
		return "Your Name";
	}
	public function getDefaultMethod()
	{
		return "defaultMethod";
	}
	public function getDefaultParams()
	{
		return array();
	}
}