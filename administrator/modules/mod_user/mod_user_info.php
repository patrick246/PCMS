<?php
class mod_user_info implements ModuleInfo
{
	public function getName()
	{
		return "User Management Module";
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
		return "showAll";
	}
	public function getDefaultParams()
	{
		return array();
	}
}