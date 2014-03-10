<?php
class mod_article_info implements ModuleInfo
{
	public function getName()
	{
		return "Article Management Module";
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