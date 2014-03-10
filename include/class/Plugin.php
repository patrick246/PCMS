<?php
abstract class Plugin
{
	/**
	 * Initializes the plugin base class
	 * @param CMS $app
	 */
	public function __construct(&$app)
	{
		$this->app = &$app;
	}
	
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
	
	protected $app;
}