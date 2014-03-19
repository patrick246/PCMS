<?php
class mod_user_controller extends Controller
{	
	public function defaultMethod()
	{
		return new Page();
	}
	
	public function showAll()
	{
		$page = new Page();
		$users = $this->app->database->getTable("User")->getAllEntries();
		$template = new Template($this->moduleBaseDir. 'templates/User/tableAll.tpl.php');
		
		$entries = "";
		foreach($users as $user)
		{
			$roleTable = $this->app->database->getTable("Role");
			$role_name = ($roleTable->idExists($user->role_id)) ? $roleTable->{$user->role_id}->name : 'Unbekannt';
			$tpl = new Template($this->moduleBaseDir . 'templates/User/tableAll.entry.tpl.php');
			$tpl->set('id', $user->id);
			$tpl->set('name', sprintf('<a href="/%s/admin/user/detail/%d">%s</a>', SUBDIR, $user->id, $user->name), $tpl->getNoEscapeFunc());
			$tpl->set('email', $user->email);
			$tpl->set('activated', $user->activated);
			$tpl->set('role', $role_name);
			$entries .= $tpl->display();
		}
		
		$template->set('entries', $entries, $template->getNoEscapeFunc());
		$page->mainContent = $template->display();
		$page->title = 'Userübersicht';
		$page->addCssFile('/'.SUBDIR . '/administrator/modules/mod_user/css/showAll.css');
		return $page;
	}
	
	public function detail($id)
	{
		$page = new Page();
		$usertbl = $this->app->database->getTable("User");
		if($usertbl->idExists($id))
		{
			$user = $this->app->database->getTable("User")->{$id};
			$roleTable = $this->app->database->getTable("Role");
			$role_name = ($roleTable->idExists($user->role_id)) ? $roleTable->{$user->role_id}->name : 'Unbekannt';
			
			$template = new Template($this->moduleBaseDir . 'templates/User/detail.tpl.php');
			$template->set('id', intval($id));
			$template->set('username', $user->name);
			$template->set('email', $user->email);
			$template->set('role', $role_name);
			$template->set('roleid', $user->role_id);
			$template->set('last_action', date('H:m, d. M. Y', $user->last_action));
			$template->set('register_date', date('H:m, d. M. Y', $user->date_registered));
			$template->set('banned', $user->banned ? 'Ja' : 'Nein');
			$template->set('activated', $user->activated);
			$page->mainContent = $template->display();
			$page->title = 'User-Detailansicht';
		}
		else
		{
			$page->errorCode = 404;
			$page->errorMessage = "The user does not exist.";
		}
		
		return $page;
	}
	
	public function addForm()
	{
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/User/addForm.tpl.php');
		$accesslevels = $this->app->database->getTable("Role")->getAllEntries();
		$options = "";
		foreach ($accesslevels as $al) {
			$options .= sprintf("<option value='%s'>%s</option>\n\t\t\t", $al->id, $al->name);
		}
		$options .= "\n";
		$template->set('accesslevels', $options, $template->getNoEscapeFunc());
		$page->mainContent = $template->display();
		$page->title = 'User hinzufügen';
		//$page->addCssFile('/'.SUBDIR . '/administrator/modules/mod_user/css/addForm.css');
		return $page;
	}
	
	public function add()
	{
		$message = array();
		$error = false;
		
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/add_message.tpl.php');
		
		$username = htmlentities($_POST['username']);
		$pw = $_POST['pw'];
		$pw_repeat = $_POST['pw_repeat'];
		$role = intval($_POST['role']);
		$email = $_POST['email'];
		
		// EMPTY checks
		if(strlen($username) === 0)
		{
			$error = true;
			$message[] = "Der Username ist leer";
		}
		if(strlen($pw) === 0 || strlen($pw_repeat) === 0)
		{
			$error = true;
			$message[] = "Das Passwort ist leer";
		}
		if(strlen($email) === 0)
		{
			$error = true;
			$message[] = "Die Email ist leer";
		}
		
		// Validation tests
		$roleTable = $this->app->database->getTable("Role");
		if(!$roleTable->idExists($role))
		{
			$error = true;
			$message[] = "Die Role-ID existiert nicht: $role";
		}
		
		if(!preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $email))
		{
			$error = true;
			$message[] = "Es befindet sich ein Fehler in der Email-Adresse";
		}
		
		if($pw !== $pw_repeat)
		{
			$error = true;
			$message[] = "Die Passwörter stimmen nicht überein.";
		}
		
		if($error)
		{
			$template->set('status', 'danger');
			$template->set('message', $message, $template->getArrayEscapeFunc());
			
		}
		else 
		{
			$userTable = $this->app->database->getTable("User");
			if(!$userTable->addEntry(array(	
										'name' 	=> $username, 
										'password' 	=> sha512($pw),
										'email' 	=> $email,
										'banned'	=> 0,
										'activated' => 1,
										'role_id' => $role
					)))
			{
				$template->set('status', 'danger');
				$template->set('message', array('Es gab einen Fehler mit der Datenbank.'), $template->getArrayEscapeFunc());
			}
			else
			{
				$template->set('status', 'success');
				$template->set('id', $userTable->getLastInsertId());
				$template->set('message', 'Der User wurde erfolgreich angelegt.');
			}
			
		}
		$page->mainContent = $template->display();
		$page->title = 'User hinzugefügt';
		//echo varDump($_POST);
		return $page;
	}
	
	public function editForm($id)
	{
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/User/editForm.tpl.php');
		$userTable = $this->app->database->getTable('User');
		if(!$userTable->idExists($id))
		{
			$page->errorCode = 404;
			$page->errorMessage = "That user does not exist";
			return $page;
		}
		
		$user = $userTable->{$id};
		$template->set('name', $user->name);
		$template->set('email', $user->email);
		$template->set('id', intval($id));
		$template->set('activated', $user->activated);
		$template->set('banned', $user->banned);
		
		$roles = "";
		foreach($this->app->database->getTable('Role')->getAllEntries() as $entry)
		{
			if($user->role_id == $entry->id)
				$roles .= sprintf('<option value="%s" selected>%s</option>', $entry->id, $entry->name);
			else
				$roles .= sprintf('<option value="%s">%s</option>', $entry->id, $entry->name);
		}
		$template->set('accesslevels', $roles, $template->getNoEscapeFunc());
		
		$page->mainContent = $template->display();
		$page->title = 'User bearbeiten';
		return $page;
	}
	
	public function edit()
	{
		$page = new Page();
		$username = htmlentities($_POST['username']);
		$pw = $_POST['pw'];
		$pw_repeat = $_POST['pw_repeat'];
		$role = $_POST['role'];
		$email = $_POST['email'];
		
		$userTable = $this->app->database->getTable('User');
		if(!$userTable->idExists($_POST['user_id']))
		{
			$page->errorCode = 404;
			$page->errorMessage = "That user does not exist.";
		}
		
		$user = $userTable->{$_POST['user_id']};
		
		if(strlen($pw) != 0 && strlen($pw_repeat) != 0 && $pw === $pw_repeat)
		{
			$user->password = sha512($pw);
			//echo "Changing password";
		}
		
		if(strlen($username) != 0)
		{
			$user->name = $username;
			//echo "Changing username";
		} 
		
		//echo varDump($this->app->user);
		// We don't want that the user can downgrade himself, so disallow it
		if($this->app->user != null && $this->app->user->dbEntry()->id != $user->id)
		{
			if($this->app->database->getTable('Role')->idExists($role))
			{
				$user->role_id = $role;
				//echo "Changing Role";
				
			}
			if(!isset($_POST['activated']) || $_POST['activated'] == false)
			{
				$user->activated = 0;
				//echo "Changing Activation state";
			}
			
			if(isset($_POST['banned']) && $_POST['banned'] == true)
			{
				$user->banned = 1;
				//echo "Changing Ban State";
			}
		}
		
		if(isset($_POST['activated']) && $_POST['activated'] == true)
		{
			$user->activated = 1;
			//echo "Changing Activation State 2";
		}
		
		if(!isset($_POST['banned']) || $_POST['banned'] == false)
		{
			$user->banned = 0;
			//echo "Changing Ban State 2";
		}
		
		$user->save();
		
		$tpl = new Template($this->moduleBaseDir . 'templates/User/editMessage.tpl.php');
		$page->mainContent = $tpl->display();
		$page->title = 'User bearbeitet';
		return $page;
	}
	
	public function roleRights($id)
	{
		$page = new Page();
		$roleTable = $this->database->getTable('Role');
		if(!$roleTable->idExists($id))
		{
			$page->errorCode = 404;
			$page->errorMessage = "Die angegebene Rolle existiert nicht.";
			return $page;
		}
		
		return $page;
		
		/*$userTable = $this->database->User;
		
		if(!$userTable->idExists($id))
		{
			$page->errorCode = 404;
			$page->errorMessage = "Der User konnte nicht gefunden werden";
			return $page; 
		}
		
		$rightsTable = $this->database->Right;
		$rights = $rightsTable->getAllEntries('priority', 'DESC');
		
		$template = new Template($this->moduleBaseDir . 'templates/rightsTable.tpl.php');
		$user = new User($id, $this->app);
		
		$rightArray = array();
		foreach($rights as $right)
		{
			if($user->hasRight($right->id) == 'true')
			{
				$rightArray[$right->id] = array('name' => $right->name, 'granted' => true, 'disabled' => false);
			}
			else if($user->hasRight($right->id) == 'all')
			{
				$rightArray[$right->id] = array('name' => $right->name, 'granted' => true, 'disabled' => true);
			}
			else
			{
				$rightArray[$right->id] = array('name' => $right->name, 'granted' => false, 'disabled' => false);
			}
			
		}
		
		$template->set('rights', $rightArray, $template->getNoEscapeFunc());
		$template->set('username', $user->dbEntry()->name);
		$template->set('id', $user->dbEntry()->id);
		
		$page->mainContent = $template->display();
		*/
		
	}
}