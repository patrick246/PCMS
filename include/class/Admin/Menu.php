<?php
class Admin_Menu
{
	/**
	 * 
	 * @param CMS $app
	 */
	public function __construct(&$app)
	{
		$this->app = &$app;
		
		$table = $this->app->database->getTable("AdminMenu");
		$this->entries = $table->getAllEntries();
	}
	
	public function display()
	{
		return $this->entries;
	}
	
	/**
	 * stores a reference to the cms app
	 * @var CMS
	 */
	private $app;
}