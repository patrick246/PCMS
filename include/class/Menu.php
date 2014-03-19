<?php
class Menu
{
	/**
	 * 
	 * @param CMS $app
	 */
	public function __construct(&$app, $mode = "user")
	{
		// Load the menu data
		if($mode == "admin")
		{
			$this->table = $app->database->getTable("AdminMenu");
		} 
		else 
		{
			$this->table = $app->database->getTable("Menu");
		}
		$entries = $this->table->find('parent', '0', '=', 'priority', 'DESC');
		
		foreach($entries as $menuentry)
		{
			$this->entries[] = $this->processMenuEntry($menuentry);
		}
	}
	
	private function processMenuEntry($menuentry)
	{
		if($menuentry->type == 'dropdown')
		{
			$menuentry->link = '#';
			$classMenuEntry = new MenuEntry($menuentry);
			$subEntries = $this->table->find('parent', $menuentry->id, '=');
			foreach ($subEntries as $subEntry)
			{
				$classMenuEntry->children[] = $this->processMenuEntry($subEntry);
			}
			return $classMenuEntry;
		}
		else
		{
			$menuentry->link = DIRECTORY_SEPARATOR . SUBDIR . DIRECTORY_SEPARATOR . $menuentry->link;
			return new MenuEntry($menuentry);
		}
	}
	
	public function display()
	{
		return $this->entries;
	}
	
	private $entries;
	
	private $table; 
}

class MenuEntry
{
	/**
	 * 
	 * @param Database_TableEntry $tblentry
	 */
	public function __construct(Database_TableEntry $tblentry)
	{
		$this->link = $tblentry->link;
		$this->type = $tblentry->type;
		$this->text = $tblentry->text;
	}
	public $name, $link, $type, $text;
	public $children = array();
}