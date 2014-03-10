<?php
class Controller
{
	public final function __construct(&$app, $moduleBaseDir)
	{
		$this->app = &$app;
		$this->moduleBaseDir = $moduleBaseDir;
		$this->workingDir = $this->app->workDir;
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
	 * The directory the cms is installed in
	 * @var string
	 */
	protected $workingDir;
	
	/**
	 * A reference to the database connection
	 * @var Database_Connection
	 */
	protected $database;
}