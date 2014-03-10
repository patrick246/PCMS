<?php
class User
{
	/**
	 *
	 * @param int $id
	 * @param CMS $app
	 */
	public function __construct($id, &$app) 
	{
		$table = $app->database->getTable("User");
		$this->entry = &$table->{$id};
		$this->app = &$app;
	}
	
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
		/*
		$associationTable 		= $this->app->database->RightToRole;
		
		$user = $this->dbEntry();
		$roleId = $user->role_id;
		$assocs = $associationTable->find('role_id', $roleId, '=');
		foreach($assocs as $roleAssoc)
		{
			if($roleAssoc->right_id == 'all') return 'all';
			if($roleAssoc->right_id == $id) return 'true';
		}
		return 'false';
		*/
		return $this->getRole()->hasRight($id);
	}
	
	public function getRole()
	{
		if($this->role === null)
			$this->role = new Role($this->dbEntry()->role_id, $this->app);
		return $this->role;
	}
	
	private $entry;
	/**
	 * 
	 * @var CMS
	 */
	private $app;
	
	/**
	 * Caches the role
	 * @var Role
	 */
	private $role = null;
}