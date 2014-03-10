<?php
class mod_roles_controller extends Controller
{
	public function showAll()
	{
		$page = new Page();
		
		$roleTable = $this->database->getTable('Role');
		$roles = $roleTable->getAllEntries();
		
		$entries = "";
		foreach ($roles as $role)
		{
			$tpl = new Template($this->moduleBaseDir . 'templates/tableRoles.entry.tpl.php');
			$tpl->set('id', $role->id);
			$tpl->set('name', $role->name);
			$count = count($this->database->getTable('User')->find('role_id', $role->id, '='));
			$tpl->set('count', $count);
			$entries .= $tpl->display();
		}
		$template = new Template($this->moduleBaseDir . 'templates/tableRoles.tpl.php');
		$template->set('entries', $entries, $template->getNoEscapeFunc());
		$page->mainContent = $template->display();
		$page->title = 'Rollenübersicht';
		return $page;
	}
	
	public function edit($id)
	{
		$page = new Page();
		$roleTable = $this->database->getTable('Role');
		if(!$roleTable->idExists($id))
		{
			$page->errorCode = 404;
			$page->errorMessage = "Die Rolle wurde nicht gefunden...";
			return $page;
		}
		$role = $roleTable->$id;
		
		$template = new Template($this->moduleBaseDir . 'templates/editForm.tpl.php');
		$template->set('name', $role->name);
		$template->set('id', $role->id);
		
		$page->mainContent = $template->display();
		return $page;
	}

	public function editAction()
	{
		$page = new Page();
		$name = htmlentities($_POST['name']);
		$roleid = $_POST['id'];
		$roleTable = $this->database->getTable('Role');
		if(!$roleTable->idExists($roleid))
		{
			$page->errorCode = 404;
			$page->errorMessage = 'Die Rolle wurde nicht gefunden...';
			return $page;
		}
		$role = $roleTable->$roleid;
		$role->name = $name;
		$role->save();
		
		$page->mainContent = '<div class="alert alert-success">Erfolgreich</div>';
		return $page;
	}
	
	public function editRights($id)
	{
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/editRightsForm.tpl.php');
		$template->set('id', $id);
		
		$rights = $this->database->getTable('Right')->getAllEntries('priority', 'DESC');
		$role = new Role($id, $this->app);
		
		$entries = "";
		if($role->hasAllRight())
		{
			$tpl = new Template($this->moduleBaseDir . 'templates/editRightsForm.entry.tpl.php');
			$tpl->set('rightID', 'all');
			$tpl->set('rightName', 'Vollzugriff');
			$tpl->set('rightGranted', true);
			$entries .= $tpl->display();
			$entries .= '<p class="alert alert-info">Die Rolle hat Vollzugriff</p>';
		}
		else
		{
			foreach($rights as $right)
			{
				$name = $right->name;
				$right_id = $right->id;
				$granted = $role->hasRight($right->id);
				$tpl = new Template($this->moduleBaseDir . 'templates/editRightsForm.entry.tpl.php');
				$tpl->set('rightID', $right_id);
				$tpl->set('rightName', $name);
				$tpl->set('rightGranted', $granted);
				$entries .= $tpl->display();
			}
		}
		$template->set('entries', $entries, $template->getNoEscapeFunc());
		
		$page->mainContent = $template->display();
		return $page;
	}
}