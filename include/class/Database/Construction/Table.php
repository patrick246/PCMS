<?php
class Database_Construction_Table
{
	public function addField(&$field)
	{
		$fields[] = &$field;
	}
	
	public function getCreateString()
	{
		// NOTHING YET LOL
		return "";
	}
	
	private $fields = array();
}