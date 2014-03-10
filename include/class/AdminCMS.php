<?php
class AdminCMS
{
	public function __construct($workingDir)
	{
		require_once $this->workDir.'include/functions/functions.php';
		loadAllFunctions($this);
		
		$this->workDir = $workingDir;
		
		$this->logger = new Logger($this, "/log/admin_log.txt");
		$this->logger->debug = true;
		
		$this->database = new Database_Connection($this, Config::DBHOST, Config::DBUSERNAME, Config::DBPASSWORD, Config::DBNAME);
		
		$this->menu = new Menu($this, 'admin');

		$this->user = (isset($_SESSION['uid']) && $this->database->getTable('User')->idExists($_SESSION['uid'])) ? new User($_SESSION['uid'], $this) : null;
		
		// Set default timezone
		date_default_timezone_set('Europe/Berlin');
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
	 * The work dir is the directory we are running in.
	 * It has a trailing slash!
	 * @var string
	 */
	public $workDir;
	
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