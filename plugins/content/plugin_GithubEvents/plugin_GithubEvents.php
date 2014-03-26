<?php
class plugin_GithubEvents extends Plugin
{
	public function display(&$page)
	{
		$translation_action = array(
					'opened' => 'erstellte',
					'closed' => 'schloss',
					'synchronize' => '?',
					'reopened' => '&ouml;ffnete'
				);
		
		
		
		$tempdir = sys_get_temp_dir();
		if($tempdir[strlen($tempdir)-1] != '/')
		{
			$tempdir .= '/';
		}
		
		
		if(!file_exists($tempdir . 'github_plugin.cache'))
		{
			$github_response = $this->getGithubResponse();
			file_put_contents($tempdir . 'github_plugin.cache', time() . '::::' . $github_response);
		}
		else
		{
			$github_response = explode('::::', file_get_contents($tempdir . 'github_plugin.cache'));
			if((time() - $github_response[0]) > 10*60 )
			{
				$github_response = $this->getGithubResponse();
				file_put_contents($tempdir . 'github_plugin.cache', time() . '::::' . $github_response);
			}
			else 
			{
				$github_response = $github_response[1];
			}
			
		}
		
		$decoded = json_decode($github_response);
		$content = '<h2>Github Events</h2><p><b>'. $this->app->database->Config->plugin_github_username->value .'...</b></p>';
		
		$i = 0;
		foreach($decoded as $event)
		{
			if($i++ == 3)
				break;
			$template = new Template($this->app->workDir . 'plugins/content/plugin_GithubEvents/templates/github_entry.tpl.php');
			$username = $event->actor->login;
			switch ($event->type)
			{
				case 'WatchEvent':
					$message = '...gab dem Repo ' . $this->getRepoLink($event) . ' einen Stern'; 
					break;
				case 'PushEvent':
					$message = '...pushte ' . count($event->payload->commits) . ' Commit(s) in das Repo ' . $this->getRepoLink($event) . ':<br>' . $this->getCommitList($event);
					break;
				case 'DeleteEvent':
					$message = '...l&ouml;schte ' . $this->getCreatedLink($event);					
					break;
				case 'PullRequestEvent':
					$message = '...' . $translation_action[$event->payload->action] .' den Pull Request' . $event->payload->number . ' f&uuml;r das Repo ' . $this->getRepoLink($event);
					break;
				case 'IssueCommentEvent':
					$message = '...gab seinen Senf zu dem Issue <a href="'. $event->payload->issue->html_url .'">#'. $event->payload->issue->number .'</a> in ' . $this->getRepoLink($event);
					break;
				case 'CommitCommentEvent':
					$message = '...gab seinen Senf zu dem Commit '. $this->getCommitCommentLink($event);
					break;
				case 'CreateEvent':
					$message = '...erstellte ein' . (($event->payload->ref_type == 'branch' || $event->payload->ref_type == 'tag')?'en ':' ') . ucfirst($event->payload->ref_type) . ', ' . $this->getCreatedLink($event);
					break;
				case 'IssuesEvent':
					//echo varDump($event->payload->issue);
					{
						if($event->payload->action === 'opened' || $event->payload->action === 'closed')
						{
							$message = '...' . (($event->payload->action === 'opened') ? 'öffnete' : 'schloss') . ' das Problem ' . $this->getIssueLink($event->payload->issue) . ' im Repo ' . $this->getRepoLink($event);
						}
						elseif ($event->payload->action === 'reopened') 
						{
							$message = '...öffnete das Problem ' . $this->getIssueLink($event->payload->issue) . ' im Repo ' . $this->getRepoLink($event) . ' wieder';
						}
						else 
						{
							$message = 'Nicht implementierter IssuesEvent-Typ: ' . $event->payload->action;
						}
					}
					break;
				default:
					$message = 'Nicht implementierter Eventtyp: ' . $event->type;
			}
			$template->set('gravatar_url', $event->actor->avatar_url . '&s=50', $template->getNoEscapeFunc());
			$template->set('message', $message, $template->getNoEscapeFunc());
			$content .= $template->display();
			
			
			
		}
		return $content;
	}
	
	private function getRepoLink($event)
	{
		return sprintf('<a href="http://github.com/%s">%s</a>', $event->repo->name, $event->repo->name);
	}
	
	private function getCreatedLink($event)
	{
		if($event->payload->ref_type == 'branch')
		{
			return $this->getRepoLink($event) . ' / ' . sprintf('<a href="http://github.com/%s/tree/%s">%s</a>', $event->repo->name, $event->payload->ref, $event->payload->ref);
		}
		else if($event->payload->ref_type == 'repository')
		{
			return $this->getRepoLink($event);
		}
		else if($event->payload->ref_type == 'tag')
		{
			
		}
	}
	
	private function getIssueLink($issue)
	{
		return sprintf('<a href="%s">#%d</a>', $issue->html_url, $issue->number);
	}
	
	private function getCommitCommentLink($event)
	{
		return sprintf('<a href="http://github.com/%s/commit/%s">%s</a>', $event->repo->name, $event->payload->comment->commit_id, substr($event->payload->comment->commit_id, 0, 7));
	}
	
	private function getCommitList($event)
	{
		$commits = '';
		foreach($event->payload->commits as $commit)
		{
			$commits .= sprintf('<a href="http://github.com/%s/commit/%s">%s</a><br>', $event->repo->name, $commit->sha,substr($commit->sha, 0, 7));
		}
		return $commits;
	}
	
	private function getGithubResponse()
	{
		$context = stream_context_create(array('http' => array('user_agent' => 'PCMS GitHub Plugin')));
		$link = sprintf('https://%1$s:%2$s@api.github.com/users/%1$s/events', $this->app->database->Config->plugin_github_username->value, $this->app->database->Config->plugin_github_password->value);
		return file_get_contents($link, false, $context);
	}
	
	public static function shouldDisplay(&$app)
	{
		return true;
	}
}