<?php
class mod_article_controller extends Controller
{	
	public function all($page)
	{
		$page = new Page();
		
		$entries = $this->app->database->getTable("Article")->getAllEntries();
		usort($entries, function($elem1, $elem2)
		{
			if($elem1->time_created == $elem2->time_created) return 0;
			return ($elem1->time_created > $elem2->time_created) ? -1 : 1;
		});
		$page->mainContent = "";
		
		foreach($entries as $key => $entry)
		{
			$user = $this->app->database->getTable("User")->{$entry->author_id};
			$tpl = new Template($this->app->workDir . Config::MODULE_DIR . 'mod_article/template/article_entry.tpl.php');
			$tpl->set('id', $entry->id);
			$tpl->set('author', $user->name);
			/*if(strlen($entry->content) > 75)
			{
				$tpl->set('content', '<i>Artikel zu lang für die Vorschau</i>', $tpl->getNoEscapeFunc());
			}
			else
			{
				$tpl->set('content', $entry->content, $tpl->getNoEscapeFunc());
			}*/
			$tpl->set('content', '');
			$tpl->set('title', $entry->title);
			$tpl->set('link_to_article', true);
			$content = $tpl->display();
			$page->mainContent .= $content;
			
		}
		$page->title = "Alle Artikel";
		$page->addMeta("author", '', "name");
		$page->addCssFile('/' . SUBDIR . DIRECTORY_SEPARATOR . Config::MODULE_DIR . "mod_article/template/article_entry.css");
		return $page;
	}
	
	public function show($id)
	{
		$page = new Page();
		$articleTable = $this->app->database->getTable('Article');
		if(is_numeric($id))
		{
			if($articleTable->idExists($id))
			{
				$article = $articleTable->{$id};
			}
			else
			{
				$page->errorCode = 404;
				$page->errorMessage = "Es wurde kein passender Artikel gefunden";
			}
		} else {
			$article = $articleTable->find('url_title', $id, "=");
			if(count($article) == 0)
			{
				$page->errorCode = 404;
				$page->errorMessage = "Es wurde kein passender Artikel gefunden";
			}
			else
			{
				$article = $article[0];
			}
		}
		
		
		$user = $this->app->database->getTable("User")->{$article->author_id};
		$template = new Template($this->app->workDir . Config::MODULE_DIR . 'mod_article/template/article_entry.tpl.php');
		$template->set('id', $article->id);
		$template->set('author', $user->name);
		$template->set('content', $article->content, $template->getNoEscapeFunc());
		$template->set('title', $article->title);
		$template->set('link_to_article', false);
		$article->hits++;
		$article->save();
		$page->mainContent = $template->display();
		$page->title = $article->title;
		return $page;
	}
}