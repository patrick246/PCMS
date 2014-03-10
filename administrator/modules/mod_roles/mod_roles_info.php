<?php
class mod_roles_info implements ModuleInfo
{
	public function getName()
	{
		return "Role Management Module";
	}
	public function getVersion()
	{
		return 'v0.1';
	}
	public function getAuthor()
	{
		return 'patrick246';
	}
	public function getDefaultMethod()
	{
		return 'showAll';
	}
	public function getDefaultParams()
	{
		return array();
	}
}