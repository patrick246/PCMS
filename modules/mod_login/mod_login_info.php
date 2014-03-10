<?php
class mod_login_info implements ModuleInfo
{
	public function getName()
	{
		return "Login Module";
	}
	public function getVersion()
	{
		 return "v1.0";
	}
	public function getAuthor()
	{
		return "patrick246";
	}
	public function getDefaultMethod()
	{
		return "show";
	}
	public function getDefaultParams()
	{
		return array();
	}
}