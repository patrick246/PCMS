<?php
class AdminCMS
{
	public function __construct($workingDir)
	{
		// Set default timezone
		date_default_timezone_set('Europe/Berlin');
		
		require_once PATH_SUBDIR . 'include/functions/functions.php';
		loadAllFunctions($this);

		$configFile = file_get_contents(PATH_SUBDIR . 'conf/config.json');
		if(!$configFile)
		{
			header('Location: /' . URL_SUBDIR . 'installation');
			die();
		}
		$this->config = json_decode($configFile);
		
		$this->database = new Database_Connection($this, $this->config->database->host, $this->config->database->username, $this->config->database->password, $this->config->database->dbname, $this->config->database->prefix);
		
		$this->menu = new Menu($this, 'admin');

		$this->user = (isset($_SESSION['uid']) && $this->database->getTable('User')->idExists($_SESSION['uid'])) ? new User($_SESSION['uid'], $this) : null;
		
		
	}
	
	public function run()
	{
		if($this->user != null && $this->user->getRole()->hasRight('access_administration'))
		{
			$page = Dispatcher::dispatch($this, 'administrator/modules/', 'admin');
			$dmgr = new Admin_DesignManager($this, $page->errorCode);
			echo $dmgr->display($page);
		} 
		else 
		{
			$page = new Page();
			$page->errorCode = 403;
			$page->errorMessage = "Du hast keine Berechtigung den Adminbereich zu betreten.";
			$dmgr = new Admin_DesignManager($this, $page->errorCode);
			echo $dmgr->display($page);
		}
	}
	
	/**
	 * This is the main database connection
	 * @var Database_Connection
	 */
	public $database;
	
	/**
	 * This is the HTTP-Request with get and post fields
	 * @var Request
	 */
	public $request;
	
	/**
	 * This is the main instance of the logger class
	 * @var Logger
	 */
	public $logger;
	
	/**
	 * An instance of the menu class
	 * @var Menu
	 */
	public $menu;
	
	/**
	 * An instance representing the current User
	 * @var User
	 */
	public $user;
}