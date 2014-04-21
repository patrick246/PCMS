<?php
/**
 * @date 31.10.13
 * @author patrick
 *
 */

require_once 'include/class/Logger.php';

class CMS 
{
	/**
	 * The constructor of the cms class initializes the class fields such as database connection
	 * @author patrick246
	 * @return new Instance of the CMS class
	 * @access public
	 * @since 1.0
	 */
	public function __construct($workDir)
	{
		// Set default timezone
		date_default_timezone_set('Europe/Berlin');
		
		// Set the main include dir
		$this->workDir = $workDir.'/';
		
		// First thing to do is initializing the logger as all other classes constructors rely on it
		$this->logger = new Logger($this, "log/log.txt");
		$this->logger->debug = true;
		
		// Now we load every function inside the include/functions folders
		require_once $this->workDir.'include/functions/functions.php';
		loadAllFunctions($this);
		
		// Then we set up the database connection
		$this->database = new Database_Connection($this, Config::DBHOST, Config::DBUSERNAME, Config::DBPASSWORD, Config::DBNAME);
	
		// Set up the session
		if(!isset($_SESSION['uid']))
		{
			$_SESSION['uid'] = 0;	// Set the userid = 0, means not logged in
			$this->user = null;
		}
		else
		{
			$this->user = $this->database->getTable('User')->idExists($_SESSION['uid']) ? $this->database->getTable('User')->{$_SESSION['uid']} : null;
		}

		$this->menu = new Menu($this);
		$this->captchaManager = new Plugin_CaptchaManager($this);
	}

	/**
	 * This is the main database connection
	 * @var Database_Connection
	 */
	public $database;
	
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
	
	/**
	 * A class responsible for providing and checking Captchas
	 * @var Plugin_CaptchaManager
	 */
	public $captchaManager;
	
	/* Methods */
	public function run() 
	{
		$this->updateUserActive();
		$this->updateVisitors();
		$page = Dispatcher::dispatch($this);
		$designmgr = new DesignManager($this, $page->errorCode);
		$designmgr->display($page);
	}
	
	private function updateUserActive()
	{
		if(isset($_SESSION['login']) && $_SESSION['login'])
		{
			$table = $this->database->getTable("User");
			$uid = $_SESSION['uid'];
			$table->{$uid}->last_action = time();
			$table->{$uid}->save();
		}
	}
	
	private function updateVisitors()
	{
		if(!isset($_SESSION['login']) || $_SESSION['login'] === false)
		{
			$table = $this->database->getTable("Visitor");
			$time = time();
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Referrer not set';
			$query_str = $_SERVER['QUERY_STRING'];
			$table->addEntry(array(
						'time_visited' => $time,
						'ip' => $ip,
						'referrer' => $referrer,
						'user_agent' => $user_agent,
						'querystring' => $query_str
					));
		}
	}
}