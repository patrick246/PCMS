<?php
class PluginManager
{
	/**
	 * 
	 * @param CMS $app
	 * @param Page $page
	 */
	public function __construct(&$app, &$page)
	{
		$this->app =& $app;
		$this->page =& $page;
		$this->table = $app->database->getTable("Plugin");
	}
	
	public function getContentByBox($box)
	{
		$allPluginsForBox = $this->table->find('box', $box, '=');
		
		$boxContent = "";
		
		foreach ($allPluginsForBox as $pluginEntry) {
			$pluginName = $pluginEntry->name;
			$path = $this->app->workDir . 'plugins/content/plugin_' . $pluginName . '/plugin_' . $pluginName . '.php';
			if(!file_exists($path))
			{
				trigger_error("Plugin file does not exist: " . $path . ', ' . $pluginName, E_USER_WARNING);
				$boxContent .= "ERROR";
			}
			require_once $path;
			$classname = 'plugin_' . $pluginName;
			// Ask the plugin politely if it wants to be displayed
			if($classname::shouldDisplay($this->app))
			{
				$plugin = new $classname($this->app);
				$boxContent .= $plugin->display($this->page);
			}
		}
		return $boxContent;
	}
	
	private $app;
	private $page;
	private $table;
}