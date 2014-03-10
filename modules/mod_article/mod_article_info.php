<?php
class mod_article_info implements ModuleInfo
{
	public function getName()
	{
		return "Article Module";
	}
	
	public function getVersion()
	{
		return "1.0";
	}
	
	public function getAuthor()
	{
		return "patrick246";
	}
	
	public function getDefaultMethod()
	{
		return "all";
	}
	
	public function getDefaultParams()
	{
		return array(1);
	}
}