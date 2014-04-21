<?php
if(!defined('_EXEC')) die('No direct access!');
class CSRF
{
	private function __construct(){}
	
	public static function token($noHTML = false)
	{
		// Generate prefix
		$characters = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'), array('$', '!', '%', '=', '?', '(', ')', '@'));
		$characters_lenght = count($characters);
		$prefix = '';
		for($i = 0; $i < 20; ++$i)
		{
			$prefix .= $characters[rand(0, $characters_lenght-1)];
		}
		
		$token = uniqid($prefix, true);
		$_SESSION['csrf_token'] = $token;
		
		if($noHTML)
			return $token;
	
		return sprintf('<input type="hidden" name="csrf_token" value="%s" />', $token);
	}
	
	public static function check($method = 'POST')
	{
		// Choose request array
		if(strtoupper($method) == 'POST')
		{
			$methodArr = $_POST;
		}
		else if(strtoupper($method) == 'GET')
		{
			$methodArr = $_GET;
		}
		else 
		{
			return false; // Or maybe throw exception
		}
		
		// Fail if no token is given
		if(!isset($_SESSION['csrf_token']) || !isset($methodArr['csrf_token']))
			return false;
		
		// Check if both are the same
		$valid = ($_SESSION['csrf_token'] == $methodArr['csrf_token']);
		
		// Delete token
		unset($_SESSION['csrf_token']);
		
		return $valid;
	}
}
