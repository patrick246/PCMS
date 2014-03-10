<?php
class Database_Construction_TableEntry
{
	/**
	 * The name of the field to be created
	 * @var string
	 */
	public $name;
	
	/**
	 * The mysql type of the field
	 * @var string
	 */
	public $type;
	
	/**
	 * Auto Increment?
	 * @var bool
	 */
	public $a_i;
	
	/**
	 * primary, unique, index, fulltext?
	 * @var string
	 */
	public $index_type;
	
	/**
	 * 
	 * @var int
	 */
	public $length;
	
	/**
	 * Should null be allowed?
	 * @var bool
	 */
	public $not_null;
	
	public function getCreateLine()
	{
		$line = $this->name . ' ' . $this->type;
		if($this->length != 0)
		{
			$line .= '(' . $this->length . ')';
		}
		$line .= ' ';
		if($this->not_null)
		{
			$line .= 'NOT_NULL ';
		}
		if($this->a_i)
		{
			$line .= 'AUTO_INCREMENT ';
		}
		
		$line .= ',';
		return $line;
	}
}