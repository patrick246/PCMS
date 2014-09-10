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
			$tpl = new Template($this->moduleBaseDir . 'template/article_entry.tpl.php');
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
		$page->addCssFile($this->moduleBaseDir . "template/article_entry.css");
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
		
		
		
		$template = $this->fillArticleDetail($article);
		
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
		$comments = $commentTable->find('article', $article->id, '=', 'date_written', 'ASC');
		
		// If user has the right to see unapproved comments, don't filter them out 
		if(!$this->app->userRole->hasRight('comment_see_unapproved'))
		{
			$comments = array_filter($comments, function($val){
				return $val->published;
			});
		}
		
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
			$tpl->set('approved', $comment->published);
			$tpl->set('can_approve', $this->app->userRole->hasRight('comment_approve'));
			
			// ToDo: Enable editing own comments
			$tpl->set('can_edit', $this->app->userRole->hasRight('comment_edit'));
			
			$tpl->set('can_delete', $this->app->userRole->hasRight('comment_delete'));
			$commentsStr .= $tpl->display();
		}
		return $commentsStr;
	}

	private function fillArticleDetail($article)
	{
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
		$template->set('needs_captcha', !$this->app->userRole->hasRight('comment_without_captcha'));
		$template->set('captcha_code', $this->app->captchaManager->getHTML(), $template->getNoEscapeFunc());
		
		return $template;
	}
	
	public function addComment($articleId)
	{
		$page = new Page();
		$articleTable = $this->app->database->getTable('Article');
		$article = null;
		if(is_numeric($articleId))
		{
			if($articleTable->idExists($articleId))
			{
				$article = $articleTable->{$articleId};
			}
			else
			{
				return generateResourceNotFoundPage();
			}
		} else {
			$article = $articleTable->find('url_title', $articleId, "=");
			if(count($article) == 0)
			{
				return generateResourceNotFoundPage();
			}
			else
			{
				$article = $article[0];
			}
		}
		
		
		$template = $this->fillArticleDetail($article);
		
		$article->hits++;
		$article->save();
		$page->title = $article->title;
		$page->addCssFile(URL_SUBDIR . 'modules/mod_article/template/article_entry.css');
		
		$errors = array();
		
		// Check CSRF Token
		if(!CSRF::check())
			return generateInvalidTokenPage();
		
		// Check Captcha if needed
		if(!$this->app->userRole->hasRight('comment_without_captcha'))
		{
			if(!$this->app->captchaManager->check())
			{
				$errors[] = 'Das Captcha wurde nicht korrekt eingegeben.';
			}
		}
		
		// Check if username collides with existing user
		if(count($this->database->User->find('name', $_POST['username'], '=')))
		{
			$errors[] = 'Der Username wurde schon registriert.';
		}
		
		// Check if email is valid
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$errors[] = 'Die angegebene Email scheint nicht korrekt zu sein';
		}
		
		// If the URL does not start with an http:// or https:// then add http://. It may be an URL like www.example.com
		if(substr($_POST['homepage'], 0, strlen('http://')) != 'http://' || substr($_POST['homepage'], 0, strlen('https://')) != 'https://')
			$_POST['homepage'] = 'http://' . $_POST['homepage'];
		
		// Check homepage
		if(!filter_var($_POST['homepage'], FILTER_VALIDATE_URL))
		{
			$errors[] = 'Die angegebene URL scheint nicht korrekt zu sein.';
		}
		
		if(strlen($_POST['content']) == 0)
		{
			$errors[] = 'Es wurde kein Kommentartext eingegeben.';
		}
		
		// If a check failed
		if(count($errors))
		{
			$template->set('errors', $errors);
			$template->set('username', $_POST['username']);
			$template->set('email', $_POST['email']);
			$template->set('homepage', $_POST['homepage']);
			$template->set('comment_content', $_POST['content']);
	
			$page->mainContent = $template->display();	
			return $page;
		}
		
		// We got here, so no input errors occurred
		
		// Gather data
		$guestcomment = is_null($this->app->user);
		if($guestcomment)
		{
			$username = $_POST['username'];
			$email = $_POST['email'];
			$homepage = $_POST['homepage'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$name = 0;
		}
		else
		{
			$username = null;
			$email = null;
			$homepage = null;
			$name = $this->app->user->dbEntry()->name;
		}
		
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$published = !$this->database->Config->comment_needApproval->value || $this->app->userRole->hasRight('comment_without_approval');
				
		$this->database->Comment->addEntry(array(
			'article' => $articleId,
			'guestcomment' => $guestcomment,
			'user' => $name,
			'guest_name' => $username,
			'guest_website' => $homepage,
			'guest_email' => $email,
			'ip' => $ip,
			'content' => $_POST['content'],
			'date_written' => time(),
			'published' => $published
		));
		
		$template->set('success', true);
		$template->set('needsApproval', (bool)$this->database->Config->comment_needApproval->value);
		$page->mainContent = $template->display();
		return $page;
	}
}