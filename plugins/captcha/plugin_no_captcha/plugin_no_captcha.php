<?php
if(!defined('_EXEC')) die('No direct access!');
class plugin_no_captcha extends Plugin_CaptchaPlugin
{
	public function getHTML()
	{
		return '';
	}
	public function checkCode()
	{
		return true;
	}
}
