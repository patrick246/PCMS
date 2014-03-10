<?php
/*
 * XML RPC server file
 * we are just accepting Pingbacks here
 */

class XMLRPCApp
{
	public function __construct()
	{
		$this->workDir = dirname(__FILE__).'/';
		
		require_once 'include/functions/functions.php';
		loadAllFunctions($this);
		
		$this->database = new Database_Connection($this, Config::DBHOST, Config::DBUSERNAME, Config::DBPASSWORD, Config::DBNAME);
	}
	
	public function run()
	{
		$headers = getallheaders();
		if($_SERVER['REQUEST_METHOD'] != 'POST')
			die("Only POST-Requests!");
	}
	
	public $workDir;
	public $database;
}

$xmlrpcapp = new XMLRPCApp();
$xmlrpcapp->run();