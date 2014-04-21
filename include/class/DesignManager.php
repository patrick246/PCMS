<?php
class DesignManager
{
	/**
	 * Constructs a new instance of the design manager
	 * @param CMS $app
	 */
	public function __construct(&$app, $error) 
	{
		$this->app =& $app;
		$this->error = $error;
		
		// Get the active design
		$configTable = $app->database->getTable("Config");
		$active = $configTable->activeDesign->value;
		
		// Build the path to the info class
		$path = $app->workDir . 'designs' . '/' . $active . '/' . $active . '_info.php';
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
		$tpl_file = $app->workDir . 'designs' . '/' . $active . '/';
		
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
		
		if($this->error != 0)
		{
			header($_SERVER['SERVER_PROTOCOL']." ".$this->error);
			$this->tpl->set('error_code', $this->error);
			$this->tpl->set('error_description', $page->errorMessage."<br><br>We are sorry that this error happened to you. <br>We're going to rent some highly trained monkeys from Youtube to fix this error.", $this->tpl->getNoEscapeFunc());
		} 
		else 
		{
			$pluginManager = new Plugin_ContentManager($this->app, $page);
			// Set the content plugin boxes
			foreach($this->info->getPluginBoxes() as $pluginBox)
			{
				$this->tpl->set($pluginBox, $pluginManager->getContentByBox($pluginBox), $this->tpl->getNoEscapeFunc());
			}
			$pagename = $this->app->database->getTable('Config')->pageName->value;
			$this->tpl->set('title', $page->title . ' | ' . $pagename);
			$this->tpl->set('header', $pagename);
			$this->tpl->set('content', $page->mainContent, $this->tpl->getNoEscapeFunc());
			$this->tpl->set('menu', $this->app->menu->display(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('css', $page->getCssFiles(), $this->tpl->getNoEscapeFunc());
			$this->tpl->set('footer', '');
			
		}
		
		$this->tpl->set('meta', $page->getMeta(), $this->tpl->getNoEscapeFunc());
		$this->tpl->set('pagetitle', $page->title);
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
	
	/**
	 * Error code from the module or dispatcher
	 * @var int
	 */
	private $error;
}