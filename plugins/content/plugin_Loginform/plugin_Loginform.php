<?php
class plugin_Loginform extends Plugin
{	
	public function display(&$page)
	{
		if(isset($_SESSION['login']) && $_SESSION['login'])
		{
			$template = new Template($this->app->workDir . 'plugins/content/plugin_Loginform/templates/loginmessage.tpl.php');
			$user = new User($_SESSION['uid'], $this->app);
			$template->set('username', $user->dbEntry()->name);
		} 
		else
		{
			$template = new Template($this->app->workDir . 'plugins/content/plugin_Loginform/templates/loginform.tpl.php');
			
			$page->addCssFile('/' . SUBDIR . '/plugins/content/plugin_Loginform/css/form.css');
		}
		return $template->display();
	}
	
	/**
	 * 
	 * @param CMS $app
	 * @return bool
	 */
	public static function shouldDisplay(&$app)
	{
		return true;
	}
}