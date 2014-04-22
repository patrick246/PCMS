<?php
class Role
{
	/**
	 * Constructs a new Role object with given id
	 * @param string $id
	 * @param CMS $app
	 */
	public function __construct($id, &$app)
	{
		$this->app =& $app;
		$roleTable = $this->app->database->getTable('Role');
		if($roleTable->idExists($id))
			$this->entry = $roleTable->$id;
		else
			throw new ErrorException('Wrong Role ID');
	}
	
	/**
	 * Returns the current entry
	 * @return Database_TableEntry
	 */
	public function dbEntry()
	{
		return $this->entry;
	}
	
	/**
	 *
	 * @param string $id
	 */
	public function hasRight($id)
	{
		// If we have a cached value, use it
		if(array_key_exists($id, $this->rights))
			return $this->rights[$id];
		
		// Check if the user is god
		if($this->hasAllRight()) return true;
		
		
		$associationTable = $this->app->database->RightToRole;

		$roleId = $this->dbEntry()->id;
		$assocs = $associationTable->find('role_id', $roleId, '=');
		
		$has = false;
		foreach($assocs as $roleAssoc)
		{
			if($roleAssoc->right_id == $id)
			{
				$has = true;
				break;
			}
		}
		$this->rights[$id] = $has;
		return $has;
	}
	
	/**
	 * Alias for hasAllRight
	 * @return boolean
	 */
	public function isGod()
	{
		return $this->hasAllRight();
	}
	
	/**
	 * Checks whether the role has the 'all' right, that means it can do EVERYTHING
	 * @return boolean
	 */
	public function hasAllRight()
	{
		// Cached value
		if(array_key_exists('all', $this->rights))
			return $this->rights['all'];
		
		$associationTable = $this->app->database->RightToRole;
		
		$roleId = $this->dbEntry()->id;
		$assocs = $associationTable->find('role_id', $roleId, '=');
		
		$has = false;
		foreach($assocs as $roleAssoc)
		{
			if($roleAssoc->right_id == 'all') 
			{
				$has = true;
				break;
			}
		}
		$this->rights['all'] = $has;
		return $has;
	}
	
	public static function getDefaultRole(&$app)
	{
		$defaultRole = $app->database->Config->defaultRole->value;
		return new Role($defaultRole, $app);
	}
	
	/**
	 * A reference to the application object
	 * @var CMS
	 */
	private $app;
	
	/**
	 * The DB-Entry for this object
	 * @var unknown_type
	 */
	private $entry;
	
	/**
	 * caches if the role has a specific right
	 * @var Array of bool
	 */
	private $rights = array();
}