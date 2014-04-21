<?php
class mod_article_controller extends Controller
{	
	public function all($page)
	{
		$page = new Page();
		
		$entries = $this->app->database->getTable("Article")->getAllEntries('time_created', 'DESC');
		
		$page->mainContent = "<h2>Alle Artikel</h2>";
		
		foreach($entries as $entry)
		{
			$user = $this->app->database->getTable("User")->{$entry->author_id};
			$tpl = new Template($this->app->workDir . Config::MODULE_DIR . 'mod_article/template/article_entry.tpl.php');
			$tpl->set('id', $entry->id);
			$tpl->set('author', $user->name);
			
			$tpl->set('content', $entry->content, $tpl->getNoEscapeFunc());

			$tpl->set('title', $entry->title);
			$tpl->set('link_to_article', true);
			$content = $tpl->display();
			$page->mainContent .= $content;
			
		}
		$page->title = "Alle Artikel";
		$page->addMeta("author", '', "name");
		$page->addCssFile(URL_SUBDIR .  Config::MODULE_DIR . "mod_article/template/article_entry.css");
		return $page;
	}
	
	public function show($id)
	{
		$page = new Page();
		$articleTable = $this->app->database->getTable('Article');
		$article = null;
		if(is_numeric($id))
		{
			if($articleTable->idExists($id))
			{
				$article = $articleTable->{$id};
			}
			else
			{
				return generateResourceNotFoundPage();
			}
		} else {
			$article = $articleTable->find('url_title', $id, "=");
			if(count($article) == 0)
			{
				return generateResourceNotFoundPage();
			}
			else
			{
				$article = $article[0];
			}
		}
		
		
		$user = $this->app->database->getTable("User")->{$article->author_id};
		$template = new Template($this->moduleBaseDir . 'template/article_entry_detail.tpl.php');
		
		$template->set('id', $article->id);
		$template->set('author', $user->name);
		$template->set('content', $article->content, $template->getNoEscapeFunc());
		$template->set('title', $article->title);
		$template->set('hits', $article->hits+1);
		
		if($article->time_last_changed)
		{
			$template->set('time_last_changed', date('d.m.Y H:i', $article->time_last_changed));
		}
		else
		{
			$template->set('time_last_changed', date('d.m.Y H:i', $article->time_created));
		}
		
		$template->set('comments', $this->getComments($article), $template->getNoEscapeFunc());
		$template->set('logged_on', $this->app->user != null);
		$template->set('needs_captcha', !$this->app->user->hasRight('comment_without_captcha'));
		$template->set('captcha_code', $this->app->captchaManager->getHTML(), $template->getNoEscapeFunc());
		
		$article->hits++;
		$article->save();
		$page->mainContent = $template->display();
		$page->title = $article->title;
		$page->addCssFile(URL_SUBDIR . 'modules/mod_article/template/article_entry.css');
		return $page;
	}
	
	private function getComments($article)
	{
		$commentTable = $this->database->getTable('Comment');
		$comments = $commentTable->find('article', $article->id, '=', 'date_written', 'DESC');
		
		if(count($comments) == 0)
		{
			return 'Keine Kommentare vorhanden';
		}
		
		$commentsStr = "";
		foreach ($comments as $comment) 
		{
			if($comment->guestcomment)
			{
				$email = $comment->guest_email;
				$username = $comment->guest_name;
				$homepage = $comment->guest_website;
				
			}
			else
			{
				$user = $this->database->User->{$comment->user};
				$email = $user->email;
				$username = $user->name;
				$homepage = '';
				
			}
			
			if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
			{
    			// SSL connection
    			$profilePic = 'https://secure.gravatar.com/avatar/';
			}
			else 
			{
				$profilePic = 'http://www.gravatar.com/avatar/';
			}
			
			// Default = Identicon, Rating: PG (mild violence, swear words, rude gestures but no intense violence or nudity or hard drug use)
			$profilePic .= md5(strtolower($email)) . '?d=identicon&r=pg';
			
			$date = date('d.m.Y H:i', $comment->date_written);
			
			$tpl = new Template($this->moduleBaseDir . 'template/comment_entry.tpl.php');
			$tpl->set('profile_pic', $profilePic);
			$tpl->set('username', $username);
			$tpl->set('homepage', $homepage);
			$tpl->set('date', $date);
			$tpl->set('content', $comment->content);
			$commentsStr .= $tpl->display();
		}
		return $commentsStr;
	}

	public function addComment()
	{
		if(!CSRF::check())
			return generateInvalidTokenPage();
		
	}
}