<?php
class plugin_Skeleton extends Plugin
{
	public function __construct(&$app)
	{
		parent::__construct($app);
	}
	
	public function display(&$page)
	{
		
	}
	
	public static function shouldDisplay(&$app)
	{
		return true;
	}
}