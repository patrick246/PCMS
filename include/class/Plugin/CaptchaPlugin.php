<?php
if(!defined('_EXEC')) die('No direct access!');
abstract class Plugin_CaptchaPlugin extends Plugin_Plugin
{
	public abstract function getHTML();
	public abstract function checkCode();
}
