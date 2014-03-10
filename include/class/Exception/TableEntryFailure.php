<?php
class Exception_TableEntryFailure extends Exception
{
	public function __construct($message, $idMissing)
	{
		$this->message = $message;
		$this->idMissing = $idMissing;
	}
	
	public $message;
	public $idMissing;
}