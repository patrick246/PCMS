<?php
if(!defined('_EXEC')) die('No direct access!');
abstract class Plugin_ContentPlugin extends Plugin_Plugin
{
	/**
	 * Returns the content of the plugin
	 * @param Page $page
	 * @return string
	 */
	public abstract function display(&$page);
	
	/**
	 * Decides if the plugin should be displayed
	 * @param CMS $app
	 * @return bool
	 */
	public static function shouldDisplay(&$app)
	{
		return true;
	}
	
}
