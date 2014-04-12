<?php
class plugin_FooterContent extends Plugin
{	
	public function display(&$page)
	{
		return $this->app->database->Config->footerContent->value;
	}
	
	public static function shouldDisplay(&$app)
	{
		return true;
	}
}