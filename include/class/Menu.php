<?php
class Menu
{
	/**
	 * 
	 * @param CMS $app
	 */
	public function __construct(&$app, $mode = "user")
	{
		$this->mode = $mode;
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
			if($this->mode == 'user')
				$menuentry->text .= ' &#9662;';
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
			$menuentry->link = URL_SUBDIR . $menuentry->link;
			return new MenuEntry($menuentry);
		}
	}
	
	public function display()
	{
		return $this->entries;
	}
	
	private $entries;
	
	private $table; 
	
	private $mode;
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