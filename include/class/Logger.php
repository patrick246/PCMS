<?php
/**
 * This is the Logger class. It logs all error messages and notices to a file specified as a constructor parameter
 * No one needs to use it directly, all the logging is done over the builtin-function trigger_error.
 * @author patrick
 * @category Logging
 * @package Core
 */
class Logger
{
	/**
	 * The constructor taking the file to write and the instance of the CMS class
	 * @param CMS $app
	 * @param string $destfile
	 */
	public function __construct(&$app, $destfile) {
		$this->destfile = $destfile;
		$this->app = &$app;
		
		// This is a closure function
		// It is like a normal function but not in global scope
		// and it is saved inside the Logger class
		// I would have made it a normal function if PHP could bind parameters...
		// This is just a workaround function to give it access to the $app variable
		$bootstrap_log_function = function($errno, $message, $filename, $linenumber, $vars) use (&$app)
		{
			
			switch($errno)
			{
				case E_WARNING:
					$app->logger->log(LogMode::Warning, $message, $filename, $linenumber, $vars);
					break;
				case E_NOTICE:
					$app->logger->log(LogMode::Notice, $message, $filename, $linenumber, $vars);
					break;
				case E_USER_ERROR:
					$app->logger->log(LogMode::UserError, $message, $filename, $linenumber, $vars);
					exit(1);
					break;
				case E_USER_WARNING:
					$app->logger->log(LogMode::UserWarning, $message, $filename, $linenumber, $vars);
					break;
				case E_USER_NOTICE:
					$app->logger->log(LogMode::UserNotice, $message, $filename, $linenumber, $vars);
					break;
				default:
					$app->logger->log(LogMode::Other, $message, $filename, $linenumber, $vars);
			}
			 
			return true;
		};
		
		// Now open the file
		/*$this->res = fopen($this->app->workDir . $destfile, "a");
		if(!$this->res)
			die("Logger can't open destination file");*/
		
		set_error_handler($bootstrap_log_function, E_ALL | E_STRICT);
	}
	
	/**
	 * This function takes it parameters from the registered log function.
	 * It writes the formatted parameters to the output file and if the debug flag is set it echos it
	 * @param LogMode-Constant $logmode
	 * @param string $message
	 * @param string $filename
	 * @param int $linenumber
	 * @param array $vars
	 */
	public function log($logmode, $message, $filename, $linenumber, $vars)
	{
		$logtext = sprintf("Logmode: %s \n\tMessage: %s\n\tFile: %s\n\tLine: %s\n\tContext: %s\n\tDate: %s\n\n", 
			Logmode::toString($logmode),
			$message,
			$filename,
			$linenumber,
			varDump($vars),
			date("H:m:i, d. M. Y")
		);
		fwrite($this->res, $logtext);
		if($this->debug)
		{
			echo nl2br($logtext);
		}
		
	}
	
	public $bootstrap_log_function;
	public $debug = false;
	
	private $destfile;
	private $res;
	private $app;
	
}

/**
 * Workaround because PHP does not support Enums.
 * Also with nice toString function.
 * @author patrick
 *
 */
class LogMode
{
	const Warning = 0;
	const Notice = 1;
	const UserError = 2;
	const UserWarning = 3;
	const UserNotice = 4;
	const Other = 5;
	
	private static $modes = array(
				self::Warning => "Warning",
				self::Notice => "Notice",
				self::UserError => "User Error",
				self::UserWarning => "User Warning",
				self::UserNotice => "User Notice",
				self::Other => "Other"
			);
	
	/**
	 * 
	 * @param LogMode-Constant $logmode
	 * @return string
	 */
	static function toString($logmode)
	{
		return self::$modes[$logmode];
	}
}