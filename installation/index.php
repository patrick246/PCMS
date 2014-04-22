<?php
session_start();

class DummyCMS{};

define('URL_SUBDIR', str_replace('/installation', '', dirname($_SERVER['PHP_SELF'])) . '/');
define('PATH_SUBDIR', dirname(dirname(__FILE__)) . '/');

function __autoload($classname)
{
	$includeRoot = dirname(__FILE__) . '/../include/class/';
	$filepath = str_replace('_', '/', $classname).'.php';
	if(!file_exists($includeRoot.$filepath))
		return false;
	require_once $includeRoot.$filepath;
}

function fillDB(Database_Connection &$db)
{
	$str = file_get_contents('sql/tables.xml');
	var_dump($_SESSION);
	$str = preg_replace('/##prefix##/', $_SESSION['dbdata']['prefix'], $str);
	$tables = simplexml_load_string($str);
	$querys = $tables->structure_schemas->database->table;
	foreach ($querys as $sql) {
		$stmt = $db->getConnection()->query($sql);
	}
}

function writeDefaultDBData($connection)
{
	// Designconfig
	$configTable = $connection->getTable('Config');
	$configTable->addEntry(array('id' => 'activeDesign', 'value' => 'default2'));
	$configTable->addEntry(array('id' => 'activeAdminDesign', 'value' => 'bootstrap'));
	
	// Roles
	$roleTable = $connection->getTable('Role');
	$roleTable->addEntry(array('id'=>'admin', 'name'=>'Administrator'));
	$roleTable->addEntry(array('id'=>'user', 'name'=>'User'));
	$roleTable->addEntry(array('id'=>'public', 'name'=>'Besucher'));
	
	// Rights
	$rightTable = $connection->getTable('Right');
	$rightTable->addEntry(array('id' => 'access_administration', 'name' => 'Backend betreten', 'priority' => 0, 'module'=>'core'));
	$rightTable->addEntry(array('id' => 'all', 'name' => 'Vollzugriff', 'priority' => 10, 'module'=>'core'));
	$rightTable->addEntry(array('id' => 'create_article', 'name' => 'Artikel erstellen', 'priority' => 0, 'module'=>'admin_article'));
	$rightTable->addEntry(array('id' => 'delete_article', 'name' => 'Artikel löschen', 'priority' => 0, 'module'=>'admin_article'));
	$rightTable->addEntry(array('id' => 'edit_article', 'name' => 'Artikel bearbeiten', 'priority' => 0, 'module'=>'admin_article'));
	$rightTable->addEntry(array('id' => 'list_articles', 'name' => 'Artikel auflisten', 'priority' => 0, 'module'=>'admin_article'));
	$rightTable->addEntry(array('id' => 'edit_user', 'name' => 'User bearbeiten', 'priority' => 0, 'module'=>'admin_user'));
	$rightTable->addEntry(array('id' => 'delete_user', 'name' => 'User löschen', 'priority' => 0, 'module'=>'admin_user'));
	$rightTable->addEntry(array('id' => 'add_user', 'name' => 'User hinzufügen', 'priority' => 0, 'module'=>'admin_user'));
	
	// Right to roles
	$rtrTable = $connection->getTable('RightToRole');
	$rtrTable->addEntry(array('role_id' => 'admin', 'right_id' => 'all'));
	
	// Admin menu
	$aMenuTable = $connection->getTable('AdminMenu');
	$aMenuTable->addEntry(array('link' => '', 'text' => 'Zum Frontend', 'role_id' => 'admin', 'parent' => 0, 'type' => 'intern', 'priority' => -10));
	$aMenuTable->addEntry(array('link' => '', 'text' => 'Module', 'role_id' => 'admin', 'parent' => 0, 'type' => 'dropdown', 'priority' => 0));
	$aMenuTable->addEntry(array('link' => 'admin/user', 'text' => 'Usermanagement', 'role_id' => 'admin', 'parent' => 2, 'type' => 'intern', 'priority' => 0));
	$aMenuTable->addEntry(array('link' => 'admin/article', 'text' => 'Artikelverwaltung', 'role_id' => 'admin', 'parent' => 2, 'type' => 'intern', 'priority' => 0));
	$aMenuTable->addEntry(array('link' => 'admin/roles', 'text' => 'Rollenverwaltung', 'role_id' => 'admin', 'parent' => 2, 'type' => 'intern', 'priority' => 0));
	
	// Frontend menu
	$menuTable = $connection->getTable('Menu');
	$menuTable->addEntry(array('text' => 'Home', 'link' => '', 'role_id' => 'public', 'parent' => 0, 'type' => 'intern', 'priority' => 0));
	$menuTable->addEntry(array('text' => 'Administration', 'link' => 'admin/', 'role_id' => 'admin', 'parent' => 0, 'type' => 'intern', 'priority' => 0));
	
	// Plugins
	$pluginTable = $connection->getTable('Plugin');
	$pluginTable->addEntry(array('name' => 'Loginform', 'box' => 'sidebarBox1'));
}

function createAdminUser($name, $pw, $email, $connection)
{
	$userTable = $connection->getTable('User');
	$userTable->addEntry(array('name'=>$name, 'password'=>hash('sha512', $pw), 'role_id'=>'admin', 'email'=>$email, 'banned'=>0, 'activated'=>1, 'last_action'=>time(), 'date_registered'=>time()));
	
}

function writeConfigFile()
{
	$config_content = <<<'END'
<?php
class Config
{
	/**
	 * The hostname of the database
	 * Ususally localhost
	 * @var string
	 */
	const DBHOST 		= "##dbhost##";	
	/**
	 * The username to log into the database
	 * @var string
	 */
	const DBUSERNAME	= "##dbusername##";
	/**
	 * Password to log into the database
	 * @var string
	 */
	const DBPASSWORD	= "##dbpw##";
	/**
	 * The name of the database
	 * @var string
	 */
	const DBNAME		= "##dbname##";
	/**
	 * The prefix all table names get
	 * @var string
	 */
	const DBPREFIX		= "##dbprefix##";

	const DEFAULT_CONTROLLER 						= "article";
	const DEFAULT_CONTROLLER_METHOD 				= "all"; 
	public static $DEFAULT_CONTROLLER_PARAMS		= array(1);
	
	const MODULE_DIR	= "modules/";
	
	const DEFAULT_CONTROLLER_ADMIN 					= "dashboard";
	const DEFAULT_CONTROLLER_ADMIN_METHOD 			= "show";
	public static $DEFAULT_CONTROLLER_ADMIN_PARAMS 	= array();
}
END;

	$config_content = str_replace('##dbhost##', $_SESSION['dbdata']['host'], $config_content);
	$config_content = str_replace('##dbusername##', $_SESSION['dbdata']['user'], $config_content);
	$config_content = str_replace('##dbpw##', $_SESSION['dbdata']['pw'], $config_content);
	$config_content = str_replace('##dbname##', $_SESSION['dbdata']['name'], $config_content);
	$config_content = str_replace('##dbprefix##', $_SESSION['dbdata']['prefix'], $config_content);
	
	file_put_contents('../include/class/Config.php', $config_content);
}



$template = new Template('templates/main.tpl.php');

if(!isset($_GET['step']) || $_GET['step'] == 'start')
{
	
	$template->set('step', 'start');
	
	$content_template = new Template('templates/startcontent.tpl.php');
	
	$template->set('content', $content_template->display(), $template->getNoEscapeFunc());
	
}
else if($_GET['step'] == 'check')
{
	$template->set('step', 'check');
	
	$phpVersion = version_compare(phpversion(), '5.3.0', '>=');
	$pdoMysqlDriver = in_array('mysql', PDO::getAvailableDrivers());
	$apacheRunning = strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false;
	$modRewriteRunning = in_array('mod_rewrite', apache_get_modules());
	
	$content_template = new Template('templates/check.tpl.php');
	$content_template->set('phpversion', $phpVersion);
	$content_template->set('pdo_active', $pdoMysqlDriver);
	$content_template->set('apache', $apacheRunning);
	$content_template->set('mod_rewrite', $modRewriteRunning);
	
	$allOK = $phpVersion && $pdoMysqlDriver && $apacheRunning && $modRewriteRunning;
	$content_template->set('next', $allOK);
	
	if($allOK)
	{
		$_SESSION['check_passed'] = true;
	}
	
	$template->set('content', $content_template->display(), $template->getNoEscapeFunc());
	
}
else if($_GET['step'] == 'db')
{
	if(!isset($_SESSION['check_passed']) || $_SESSION['check_passed'] === false)
	{
		header('Location: ' . $_SERVER['PHP_SELF'].'?step=start');
		exit();
	}
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$template->set('step', 'db');
		
		// Try connecting
		$failed = false;
		try
		{
			$database = new Database_Connection(new DummyCMS(), $_POST['host'], $_POST['dbuser'], $_POST['dbpw'], $_POST['dbname'], $_POST['dbprefix'], false /* Don't catch exceptions */);
		}
		catch(PDOException $e)
		{
			$failed = true;
			$content_template = new Template('templates/dbform.tpl.php');
			$content_template->set('dbhost', $_POST['host']);
			$content_template->set('dbuser', $_POST['dbuser']);
			$content_template->set('dbpw', $_POST['dbpw']);
			$content_template->set('dbname', $_POST['dbname']);
			$content_template->set('error', $e->getMessage());
			$template->set('content', $content_template->display(), $template->getNoEscapeFunc());
		}
		
		if(!$failed)
		{
			$_SESSION['db_passed'] = true;
			$_SESSION['dbdata'] = array(
				'host' => $_POST['host'],
				'user' => $_POST['dbuser'],
				'pw'   => $_POST['dbpw'],
				'name' => $_POST['dbname'],
				'prefix' => $_POST['dbprefix']
			);
			
			
			fillDB($database);
			writeDefaultDBData($database);
			
			// Redirect to user settings
			header('Location: ' . $_SERVER['PHP_SELF'] . '?step=user');
			
		}
	}
	else
	{
		$content_template = new Template('templates/dbform.tpl.php');
		$template->set('step', 'db');
		$template->set('content', $content_template->display(), $template->getNoEscapeFunc());
		
	}	
}
elseif ($_GET['step'] == 'user') 
{
	if(!isset($_SESSION['db_passed']) || !$_SESSION['db_passed'])
	{
		header('Location: ' . $_SERVER['PHP_SELF'] . '?step=db');
		exit();
	}
	$template->set('step', 'user');
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$database = new Database_Connection(new DummyCMS(), $_SESSION['dbdata']['host'], $_SESSION['dbdata']['user'], $_SESSION['dbdata']['pw'], $_SESSION['dbdata']['name'], $_SESSION['dbdata']['prefix']);
		
		writeConfigFile();
		
		$configTable = $database->getTable("Config");
		$configTable->addEntry(array('id' => 'pageName', 'value' => $_POST['homepage_name']));
		
		
		createAdminUser($_POST['admin_username'], $_POST['admin_password'], $_POST['admin_email'], $database);
		
		header('Location: ' . $_SERVER['PHP_SELF'] . '?step=finish');
		exit();
	} 
	else 
	{
		$content_template = new Template('templates/userform.tpl.php');
		$template->set('content', $content_template->display(), $template->getNoEscapeFunc());
	}
}
else if($_GET['step'] == 'finish')
{
	$template->set('step', 'finish');
	$contentTemplate = new Template('templates/finished.tpl.php');
	$template->set('content', $contentTemplate->display(), $template->getNoEscapeFunc());
}

echo $template->display();