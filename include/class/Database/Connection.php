<?php
/**
	*   @date 01.11.2013
	*/
class Database_Connection 
{
	/**
	 * 
	 * @param CMS $app
	 * @param string $host
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 */
	public function __construct(&$app, $host, $username, $password, $database) 
	{
		$this->app = &$app;
		try
		{
			$this->conn = new PDO("mysql:host=" . $host . ";dbname=".$database.';charset=UTF8', $username, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		} 
		catch (PDOException $e)
		{
			trigger_error("Cannot connect to database. " . $e->getMessage(), E_USER_ERROR);
		}
	}
	
	/**
	 * Used to return a ready to use instance of a table that exists in the database
	 * The name parameter is automatically prefixed
	 * @param string $name UNPREFIXED
	 * @return Database_Table
	 */
	public function getTable($name)
	{
		if(!array_key_exists($name, $this->tables))
		{
			$this->tables[$name] = new Database_Table($this->app, $this, $name);
		}
		return $this->tables[$name];
	}
	
	/**
	 * 
	 * @param string $property
	 * @return Database_Table
	 */
	public function __get($property)
	{
		return $this->getTable($property);
	}
	
	public function doesTableExist($name)
	{
		$stmt = $this->conn->prepare("show tables like :tbl");
		$stmt->bindParam('tbl', $name, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->rowCount();
	}
	
	public function createTable($name, array $fields, $ifnotexists = false)
	{
		if(count($fields) != count($types))
			trigger_error("createTable: the count of elements does not match!", E_USER_WARNING);
		$sql = "CREATE TABLE ";
		if($ifnotexists)
			$sql .= "IF NOT EXISTS ";
		$sql .= $name . ' \n';
		foreach($fields as $fieldname => $fieldarr)
		{
			$sql .= $fieldname . ' ';
			$sql .= $fieldarr['type']."(".$fieldarr['size']."),\n";
		}
		$sql .= ")";
		echo $sql;
		//$this->getConnection()->exec($sql);
	}
	
	/**
	 * Prepends the table name with the prefix and quotes it
	 * @param string $name
	 * @return string
	 */
	public function processTableName($name)
	{
		return Config::DBPREFIX . $name;
	}
	
	/**
	 * Returns the pdo instance connected to the database
	 * @return PDO
	 */
	public function &getConnection()
	{
		return $this->conn;
	}
	
	
	/**
	 * 
	 * @var PDO
	 */
	private $conn;
	
	/**
	 * 
	 * @var CMS
	 */
	private $app;
	
	/**
	 * 
	 * @var Array of Database_Table
	 */
	private $tables = array();
}