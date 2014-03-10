<?php
class Database_TableEntry
{
	/**
	 * 
	 * @param CMS $app
	 * @param Database_Connection $db
	 * @param Database_Table $table
	 * @param string $id
	 */
	public function __construct(&$app, &$db, &$table, $id) {
		$this->app = &$app;
		$this->db = &$db;
		$this->tbl = &$table;
		$this->id = $id;
		
		$sql = "SELECT * FROM `" . $table->getName() . "` WHERE id = :id";
		$stmt = $db->getConnection()->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();
		
		$this->fields = $stmt->fetch(PDO::FETCH_ASSOC);
		if($this->fields === false)
			trigger_error("No results, ID does not exist! " . $id . " SQL: " . $stmt->queryString, E_USER_ERROR);
	}
	
	public function __get($property) {
		if (!array_key_exists($property, $this->fields)) {
			trigger_error("Property does not exist: ".$property, E_USER_WARNING);
		}
		return $this->fields[$property];
	}
	
	public function __set($property, $value) {
		if(!array_key_exists($property, $this->fields))
		{
			trigger_error("Property does not exist: ".$property, E_USER_WARNING);
		}
		$this->fields[$property] = $value;
	}
	
	public function save()
	{
		$sql = "UPDATE " . $this->tbl->getName() . " SET ";
		$i = 0;
		foreach ($this->fields as $key => $value)
		{
			$sql .= '`'.$key.'` = :'.preg_replace('/-/', '_', $key);
			if($i < (count($this->fields) - 1))
				$sql .= ', ';
			$i++;
		}
		$sql .= " WHERE `id` = :id";
		//echo $sql;
		
		$stmt = $this->db->getConnection()->prepare($sql);
		//echo "<br>";
		foreach($this->fields as $key => &$value)
		{
			$stmt->bindParam(':'.preg_replace('/-/', '_', $key), $value);
			//echo "Bind $key: $value <br>";
		}
		$stmt->execute();
	}
	
	/**
	 * 
	 * @var CMS
	 */
	private $app;
	/**
	 * 
	 * @var Database_Connection
	 */
	private $db;
	/**
	 * 
	 * @var Database_Table
	 */
	private $tbl;
	/**
	 * 
	 * @var array
	 */
	private $fields = array();
	/**
	 * 
	 * @var mixed
	 */
	private $id;
}