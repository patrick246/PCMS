<?php
class mod_skeleton_info implements ModuleInfo
{
	public function getName()
	{
		return "Skeleton Module";
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