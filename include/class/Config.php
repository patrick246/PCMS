<?php
class Config
{
	/**
	 * The hostname of the database
	 * Ususally localhost
	 * @var string
	 */
	const DBHOST 		= "localhost";	
	/**
	 * The username to log into the database
	 * @var string
	 */
	const DBUSERNAME	= "root";
	/**
	 * Password to log into the database
	 * @var string
	 */
	const DBPASSWORD	= "pw123";
	/**
	 * The name of the database
	 * @var string
	 */
	const DBNAME		= "cms";
	/**
	 * The prefix all table names get
	 * @var string
	 */
	const DBPREFIX		= "cmsv3_";
	
	const TMPDIR		= "tmp";

	const DEFAULT_CONTROLLER 			= "article";
	const DEFAULT_CONTROLLER_METHOD 	= "all"; 
	public static $DEFAULT_CONTROLLER_PARAMS		= array(1);
	
	const MODULE_DIR					= "modules/";
	
	const SUBDIR 	= "cms";
	
	const DEFAULT_CONTROLLER_ADMIN 			= "dashboard";
	const DEFAULT_CONTROLLER_ADMIN_METHOD 	= "show";
	public static $DEFAULT_CONTROLLER_ADMIN_PARAMS = array();
}
