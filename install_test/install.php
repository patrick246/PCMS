<?php
class setup
{
	public function __construct(&$app)
	{
		$this->admincms = &$app;
	}
	
	public function setup()
	{
		
	}
	
	private $admincms;
}