<?php
abstract class Plugin_Plugin
{
	/**
	 * Initializes the plugin base class
	 * @param CMS $app
	 */
	public final function __construct(&$app)
	{
		$this->app = &$app;
		$this->database = &$app->database;
	}
		
	protected $app;
	protected $database;
}