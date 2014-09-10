<?php
class mod_dashboard_controller extends Controller
{	
	public function show()
	{
		$page = new Page();
		$page->addCssFile(URL_SUBDIR . 'administrator/modules/mod_dashboard/css/mod_dashboard_main.css');
		
		$tpl = new Template(PATH_SUBDIR . '/administrator/modules/mod_dashboard/templates/dashboard.tpl.php');
		
		$table = $this->app->database->getTable("User");
		$entries = $table->find('last_action', time() - 5*60, '>=');
		
		$roleTable = $this->app->database->getTable('Role');
		$roles = array();
		foreach($roleTable->getAllEntries() as $entry)
		{
			$roles[$entry->id] = $entry->name;
		}
		
		$tpl->set('users', $entries, $tpl->getNoEscapeFunc());
		$tpl->set('roles', $roles, $tpl->getArrayEscapeFunc());
		
		$visitorTable = $this->database->getTable('Visitor');
		$visitorEntries = $visitorTable->find('time_visited', time() - 5*60*60, '>=', 'time_visited', 'DESC');
		
		$tpl->set('visitors', $visitorEntries, $tpl->getNoEscapeFunc());
		$tpl->set('visitor_count', count($visitorEntries));
		
		$page->mainContent = $tpl->display();
		$page->title = 'Dashboard';
		return $page;
	}
}