<?php
class mod_article_controller extends Controller
{
	public function showAll()
	{
		$page = new Page();
		$template = new Template($this->moduleBaseDir . 'templates/showAll.tpl.php');
		$articleTable = $this->database->getTable('Article');
		$articles = $articleTable->getAllEntries();
		$userTable = $this->database->User;
		$roleTable = $this->database->Role;
		
		$entries = "";
		foreach ($articles as $article)
		{
			if($userTable->idExists($article->author_id))
			{
				$author_name = $userTable->{$article->author_id}->name;
			}
			else
			{
				$author_name = "Author unbekannt";
			}
			
			if($roleTable->idExists($article->role))
			{
				$role_name = $roleTable->{$article->role}->name;
			}
			else
			{
				$role_name = "Unbekannte Rolle";
			}
			$tpl = new Template($this->moduleBaseDir . 'templates/showAll.entry.tpl.php');
			$tpl->set('id', $article->id);
			$tpl->set('title', $article->title);
			$tpl->set('author', $author_name);
			$tpl->set('time_created', $article->time_created);
			$tpl->set('hits', $article->hits);
			$tpl->set('role_name', $role_name);
			$entries .= $tpl->display();
		}
		if($this->app->user != null && $this->app->user->hasRight('list_articles'))
			$template->set('article_entries', $entries, $template->getNoEscapeFunc());
		else
			$template->set('article_entries', '<p class="alert alert-danger">Du hast keine Berechtigung um die Artikel aufzulisten</p>', $template->getNoEscapeFunc());
		$page->mainContent = $template->display();
		return $page;
	}
	
	public function edit($id)
	{
		$page = new Page();
		if($this->app->user == null || !$this->app->user->hasRight('edit_article'))
		{
			$page->errorCode = 401;
			$page->errorMessage = 'Du hast keine Berechtigung Artikel zu bearbeiten!';
			return $page;
		}
		
		$articleTable = $this->database->getTable('Article');
		if($articleTable->idExists($id))
		{
			$template = new Template($this->moduleBaseDir . 'templates/editForm.tpl.php');
			$entry = $articleTable->{$id};
			$template->set('id', $entry->id);
			$template->set('articlename', $entry->title);
			$template->set('urltitle', $entry->url_title);
			$template->set('checkedUser', $entry->author_id);
			$template->set('checkedRole', $entry->role);
			$template->set('content', $entry->content);
			
			$users = $this->database->User->getAllEntries();
			$template->set('users', $users, $template->getNoEscapeFunc());
			
			$roles = $this->database->Role->getAllEntries();
			$template->set('roles', $roles, $template->getNoEscapeFunc());
			
			$page->mainContent = $template->display();
			$page->addJSFile('/' . Config::SUBDIR . '/administrator/modules/mod_article/js/tinymce/tinymce.min.js');
			$page->addJSString('tinymce.init(
					{
						selector: "textarea",
						plugins: ["link image"],
						toolbar: "undo redo | styleselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
					});');
		}
		else
		{
			$page->errorCode = 404;
			$page->errorMessage = "Dieser Artikel existiert nicht";
		}
		return $page;
	}
	
	public function editProcess()
	{
		$page = new Page();
		$id = $_POST['article_id'];
		$title = $_POST['name'];
		$url_title = $_POST['urltitle'];
		$author_id = $_POST['author'];
		$role_id = $_POST['role'];
		$content = $_POST['content'];
		
		$articleTable = $this->database->getTable('Article');
		if(!$articleTable->idExists($id))
		{
			$page->errorCode = 404;
			$page->errorMessage = 'Der Artikel existiert nicht';
			return $page;
		}
		
		$article = $articleTable->{$id};
		$article->title = $title;
		$article->url_title = preg_replace('/ /', '_', $url_title);
		$article->author_id = $author_id;
		$article->role = $role_id;
		$article->content = $content;
		$article->time_last_changed = time();
		$article->save();
		
		$page->mainContent = 'Der Artikel wurde erfolgreich bearbeitet';
		return $page;
	}
	
	public function add()
	{
		$page = new Page();
		if($this->app->user == null || !$this->app->user->hasRight('create_article'))
		{
			$page->errorCode = 401;
			$page->errorMessage = 'Du hast keine Berechtigung einen Artikel zu erstellen';
			return $page;
		}
		$template = new Template($this->moduleBaseDir . 'templates/addForm.tpl.php');
		
		$users = $this->database->User->getAllEntries();
		$template->set('users', $users, $template->getNoEscapeFunc());
			
		$roles = $this->database->Role->getAllEntries();
		$template->set('roles', $roles, $template->getNoEscapeFunc());
		
		$page->addJSFile('/' . Config::SUBDIR . '/administrator/modules/mod_article/js/tinymce/tinymce.min.js');
		
		$page->addJSString('tinymce.init(
					{
						selector: "textarea",
						plugins: ["link image"],
						toolbar: "undo redo | styleselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
					});');
		$page->mainContent = $template->display();
		return $page;
	}
	
	public function addProcess()
	{
		$page = new Page();
		// Get the variables
		$title = $_POST['name'];
		$url_title = $_POST['urltitle'];
		$author_id = $_POST['author'];
		$role_id = $_POST['role'];
		$content = $_POST['content'];
		
		// Process the values
		if(empty($url_title))
		{
			$url_title = strtolower(preg_replace('/ /', '_', $title));
		}
		
		$articleTable = $this->database->getTable('Article');
		$articleTable->addEntry(array(
					'title' => $title,
					'url_title' => $url_title,
					'content' => $content,
					'author_id' => $author_id,
					'time_created' => time(),
					'role' => $role_id,
					'hits' => 0,
					'time_last_changed' => 0
				));
		return $page;
	}
}