<?php
class mod_login_controller extends Controller
{	
	public function show()
	{
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/form.tpl.php');
		$page->mainContent = $template->display();
		$page->addCssFile(URL_SUBDIR . 'modules/mod_login/css/form.css');
		$page->title = 'Login';
		return $page;
	}
	
	/**
	 * This function assumes that POST is used
	 * @return Page
	 */
	public function process()
	{
		$page = new Page();
		$page->title = 'Login';
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$page->mainContent = "Hello User,<p>you have accessed this page over GET. However, this page only processes POST Requests.<br>Please notify the administrator.</p>";
		} 
		else 
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				
				$table = $this->app->database->getTable("User");
				$entry = $table->find('name', $username, '=');
				if(count($entry) == '0')
				{
					// Username does not exist
					$page->mainContent = "<div class='failure'>Username oder Passwort falsch</div>";
					return $page;
				}
				
				// Check password
				$userentry = $entry[0];
				if($userentry->password === hash('sha512', $password))
				{
					$_SESSION['login'] = true;
					$_SESSION['uid'] = $userentry->id;
					$page->mainContent = "<div class='success'>Erfolgreich eingeloggt</div>";
				} else {
					// password is wrong
					$page->mainContent = "<div class='failure'>Username oder Passwort falsch</div>";
					return $page;
				}
			}
		}
		
		return $page;
	}
	
	public function logout()
	{
		$page = new Page();
		$page->title = 'Logout';
		if(isset($_SESSION['login']) && $_SESSION['login'])
		{
			// Now log the user out
			$_SESSION = array();
			session_destroy();
			session_start();
			$page->mainContent = "<div class='success'>Logged out successfully</div>";
		} else {
			$page->mainContent = "<div class='failure'>You aren't logged in</div>";
		}
		return $page;
	}
}