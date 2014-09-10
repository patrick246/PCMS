<?php
class Controller
{
	public final function __construct(&$app, $moduleBaseDir)
	{
		$this->app = &$app;
		$this->moduleBaseDir = $moduleBaseDir;
		$this->database = &$this->app->database;
		
		$this->construct();
	}
	
	protected function construct(){}
	
	/**
	 * A reference to the App instance
	 * @var CMS
	 */
	protected $app;
	
	/**
	 * The module directory
	 * @var string
	 */
	protected $moduleBaseDir;
	
	/**
	 * A reference to the database connection
	 * @var Database_Connection
	 */
	protected $database;
}