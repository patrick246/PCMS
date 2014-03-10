<?php
class Admin_DesignManager
{
	/**
	 * Constructs a new instance of the admin design manager
	 * @param CMS $app
	 */
	public function __construct(&$app, $error) {
		$this->app =& $app;
		$this->error = $error;
		
		// Get the active design
		$configTable = $app->database->getTable("Config");
		$active = $configTable->activeAdminDesign->value;
		
		// Build the path to the info class
		$path = $app->workDir . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR .'designs' . DIRECTORY_SEPARATOR . $active . DIRECTORY_SEPARATOR . $active . '_info.php';
		$classname = $active.'_info';
		if(file_exists($path))
		{
			require_once $path;
		}
		else 
		{
			trigger_error("Info class not present", E_USER_ERROR);
		}
		
		// Instantiate the info class
		$this->info = new $classname;
		
		// Get the real template file
		$tpl_file = $app->workDir . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'designs' . DIRECTORY_SEPARATOR . $active . DIRECTORY_SEPARATOR;
		if($error)
		{
			$tpl_file .= $this->info->getErrorTemplateFile();
		}
		else
		{
			$tpl_file .= $this->info->getTemplateFile();
		}
		// If the path is valid, use the file
		if(file_exists($tpl_file))
		{
			$this->tpl = new Template($tpl_file);
		}
		else
		{
			trigger_error("Template file not available!", E_USER_WARNING);
			$this->tpl = new stdClass();
			$this->tpl->set = function (){trigger_error("No template set! In Designmanager: ", E_USER_ERROR);};
		}
	}
	
	public function display(Page &$page) {
		$page->addMeta("Content-Type", "text/html; charset=utf-8", "http-equiv");
		
		if($this->error)
		{
			$this->tpl->set('error_code', $page->errorCode);
			$this->tpl->set('error_description', $page->errorMessage, $this->tpl->getNoEscapeFunc());
		}
		else
		{
			$this->tpl->set('current_username', $this->app->user ? $this->app->user->dbEntry()->name : '(nicht eingeloggt!)');
			$this->tpl->set('header', $this->app->database->getTable('Config')->pageName->value);
			$this->tpl->set('content', $page->mainContent, $this->tpl->getNoEscapeFunc());
			$this->tpl->set('menu', $this->app->menu->display(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('meta', $page->getMeta(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('css', $page->getCssFiles(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('js', $page->getJSFiles() . $page->getJSStrings(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('footer', 'FOOTER');
			
			
			// Set the content plugin boxes
			foreach($this->info->getPluginBoxes() as $pluginBox)
			{
				$this->tpl->set($pluginBox, '<p>This is a content plugin box!</p>', $this->tpl->getNoEscapeFunc());
			}
		}
		$this->tpl->set('root', Config::SUBDIR);
		$this->tpl->set('pagetitle', 'PCMS');
		$this->tpl->set('title', $page->title);
		echo $this->tpl->display();
	}
	/**
	 * Template instance for the active design
	 * @var Template
	 */
	private $tpl;
	
	/**
	 * 
	 * @var DesignInfo
	 */
	private $info;
	
	/**
	 * 
	 * @var CMS
	 */
	private $app;
	
	private $error;
}