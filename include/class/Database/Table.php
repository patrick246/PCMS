<?php
class Database_Table
{
	public function __construct(&$app, &$db, $name) {
		$this->db = &$db;
		$this->app = &$app;
		$this->name = $this->db->processTableName($name);
	}
	
	public function __get($property)
	{
		if(!array_key_exists($property, $this->fields))
		{
			// If there is no such entry, try to load it
			$this->loadEntry($property);
		}
		
		return $this->fields[$property];
	}
	
	private function loadEntry($id)
	{
		$this->fields[$id] = new Database_TableEntry($this->app, $this->db, $this, $id);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getAllEntries($sortBy = null, $order = 'ASC')
	{
		$sql = "SELECT id FROM " . $this->getName();
		
		if($sortBy !== null)
		{
			$sql .= ' ORDER BY `' . $sortBy . '` ' . $order;
		}
		
		$idsStmt = $this->db->getConnection()->query($sql);
		$ids = $idsStmt->fetchAll(PDO::FETCH_ASSOC);
		foreach($ids as $id)
		{
			//echo $id['id'];
			$this->loadEntry($id['id']);
		}
		return $this->fields;
	}
	
	public function find($name, $value, $op, $sortBy = null, $order = 'ASC')
	{
		$sql = "SELECT id FROM " . $this->getName() . " WHERE `". $name ."` ". $op ." :val";
		
		if($sortBy !== null)
		{
			$sql .= ' ORDER BY `' . $sortBy . '` ' . $order;
		}

		$stmt = $this->db->getConnection()->prepare($sql);
		$stmt->bindParam(':val', $value);
		$stmt->execute();
		
		$ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$result = array();
		foreach($ids as $id)
		{
			$result[] = $this->{$id['id']};
		}
		return $result;
	}
	
	/**
	 * Checks if a ID exists
	 * @param mixed $id
	 * @return bool 
	 */
	public function idExists($id)
	{
		$sql = "SELECT id FROM " . $this->getName();
		if($this->ids === null)
			$this->ids = $this->db->getConnection()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		foreach ($this->ids as $entry) 
		{
			if($id == $entry['id'])
				return true;
		}
		return false;
	}
	
	public function addEntry($arr)
	{
		$sql = "INSERT INTO " . $this->getName() . " (";
		
		$i = 0;
		$len = count($arr) - 1;
		foreach($arr as $key=>$value)
		{
			if($i == $len)
				$sql .= '`' . $key . '`)';
			else
				$sql .= '`' . $key . '`, ';
			$i++;
		}
		
		$sql .= " VALUES (";
		$i = 0;
		$len = count($arr)-1;
		foreach($arr as $key=>$value)
		{
			$key = preg_replace('/-/', '_', $key);
			if($i == $len)
				$sql .= ':' . $key . ')';
			else
				$sql .= ':' . $key . ',';
			$i++;
		}
		//echo $sql;
		$stmt = $this->db->getConnection()->prepare($sql);
		foreach($arr as $key=>$value)
		{
			$key = preg_replace('/-/', '_', $key);
			/*if(*/$stmt->bindValue(':' . $key, $value)/*)*/;
			
			//echo 'Binding ' . $key . ': ' . $value . "<br>\n";
		}
		return $stmt->execute();
		//echo $stmt->errorInfo()[2];
	}
	
	public function getLastInsertId()
	{
		return $this->db->getConnection()->lastInsertId();
	}
	/**
	 * 
	 * @var Database_Connection
	 */
	private $db;
	/**
	 * 
	 * @var CMS
	 */
	private $app;
	/**
	 * The processed table name
	 * @var string
	 */
	private $name;
	/**
	 * The fields in the table
	 * @var array
	 */
	private $fields = array();
	/**
	 * All IDs, lazy evaluated
	 * @var array
	 */
	private $ids = null;
}