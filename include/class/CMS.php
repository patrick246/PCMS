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
	public function __construct()
	{
		// Set default timezone
		date_default_timezone_set('Europe/Berlin');

		$this->loadConfig();
		$this->loadAllFunctions();
		$this->initDBConnection();
		$this->initSession();


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
	 * @var Role
	 */
	public $userRole; 
	 
	/**
	 * A class responsible for providing and checking Captchas
	 * @var Plugin_CaptchaManager
	 */
	public $captchaManager;

	/**
	 * The config as deserialized JSON file
	 * @var stdClass
	 */
	public $config;
	
	/* Methods */
	public function run() 
	{
		$this->updateUserActive();
		$this->updateVisitors();
		$page = Dispatcher::dispatch($this, $this->config->directories->modules);
		$designmanager = new DesignManager($this, $page->errorCode);
		$designmanager->display($page);
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

	private function loadConfig()
	{
		$configFile = file_get_contents(PATH_SUBDIR . 'conf/config.json');
		if (!$configFile) {
			header("Location: " . URL_SUBDIR . 'installation/');
			die();
		}

		$this->config = json_decode($configFile);
	}

	private function loadAllFunctions()
	{
		// Now we load every function inside the include/functions folders
		require_once PATH_SUBDIR . 'include/functions/functions.php';
		loadAllFunctions($this);
	}

	private function initDBConnection()
	{
		// Then we set up the database connection
		$this->database = new Database_Connection($this, $this->config->database->host, $this->config->database->username, $this->config->database->password, $this->config->database->dbname, $this->config->database->prefix);
	}

	private function initSession()
	{
		// Set up the session
		if (!isset($_SESSION['uid'])) {
			$_SESSION['uid'] = 0; // Set the userid = 0, means not logged in
			$this->user = null;
			$this->userRole = Role::getDefaultRole($this);
		} else {
			if ($this->database->User->idExists($_SESSION['uid'])) {
				$this->user = new User($_SESSION['uid'], $this);
				$this->userRole = $this->user->getRole();
			} else {
				$this->user = null;
				$this->userRole = Role::getDefaultRole($this);
			}
		}
	}
}