<?php
if(!defined('_EXEC')) die('No direct access!');
class Plugin_CaptchaManager
{
	public function __construct(&$app)
	{
		$this->app = &$app;
		
		// Load Captcha plugin
		$activeCaptchaName = str_replace('/', '', $this->app->database->Config->activeCaptcha->value);
		
		$filename = PATH_SUBDIR . 'plugins/captcha/plugin_' . $activeCaptchaName . '/plugin_' . $activeCaptchaName . '.php';
		if(!file_exists($filename))
			trigger_error('Captcha-Plugin nicht vorhanden', E_USER_ERROR);
		
		require_once $filename;
		$classname = 'plugin_'.$activeCaptchaName;
		$this->activeCaptchaPlugin = new $classname($this->app); 
	}
	
	public function getHTML()
	{
		if(is_null($this->activeCaptchaPlugin))
		{
			trigger_error('Captcha-Plugin nicht geladen!', E_USER_WARNING);
			return '';
		}	
		return $this->activeCaptchaPlugin->getHTML();
	}
	
	public function check()
	{
		if(is_null($this->activeCaptchaPlugin))
		{
			trigger_error('Captcha-Plugin nicht geladen!', E_USER_WARNING);
			return false;
		}
		return $this->activeCaptchaPlugin->checkCode();
	}
	
	private $activeCaptchaPlugin;
	private $app;
}
