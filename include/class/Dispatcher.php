<?php
class Dispatcher
{
	/**
	 * Calls the apropriate method and creates a new controller
	 * @param CMS $app
	 * @return Page
	 */
	public static function dispatch(&$app, $moduleDir = null, $mode = "user")
	{
		$querystr = $_SERVER['QUERY_STRING'];
		// If there is no query string, work with the default values
		if(strlen($querystr) == 0)
		{
			$classname = $app->config->routing->default_controller->frontend->name;
			$method = $app->config->routing->default_controller->frontend->method;
			$params = $app->config->routing->default_controller->frontend->params;
			if($mode == "admin")
			{
				$classname = $app->config->routing->default_controller->backend->name;
				$method = $app->config->routing->default_controller->backend->method;
				$params = $app->config->routing->default_controller->backend->params;
			}
		}
		else if($querystr == 'admin')
		{
			header("Location: admin/");
			die();
		}
		else
		{
			$arr = explode('/', $querystr);
			
			// Get the classname
			$classname = $arr[0];
			
			// Load the info class
			$p = $moduleDir . "mod_${classname}/mod_${classname}_info.php";
			if(!file_exists($p))
			{
				$page = new Page();
				$page->errorCode = 404;
				$page->title = "404";
				return $page;
			}
			require_once $p;
			$c = "mod_${classname}_info";
			$info = new $c;
			
			// Now get the method or the default value
			if(!isset($arr[1]) || strlen($arr[1]) == 0)
			{
				$method = $info->getDefaultMethod();
				$params = $info->getDefaultParams();
			} else {
				$method = $arr[1];
				unset($arr[0], $arr[1]);
				if(count($arr) == 0)
				{
					$params = $info->getDefaultParams();
				} 
				else 
				{
					$params = array_values($arr);
				}
			}
			
		}
		// The main controller class of a module consists of mod_[url-part-1]_controller
		$classname_file = 'mod_' . $classname . '_controller';
		
		// The main controller class file must be in [Module Directory]/[Module name]/[Class Name].php
		$path = $moduleDir . 'mod_' . $classname . '/';
		$filename = $classname_file . '.php';
		
		// If there is such a file
		if(file_exists($path . $filename))
		{
			// include it
			require_once $path.$filename;
			
			// and instantiate a new class
			$class = new $classname_file($app, $path);
			
			// now call the method
			$call = array($class, $method);
			if(is_callable($call))
			{
				$page = call_user_func_array($call, $params);
				if($page === null)
				{
					$page = new Page();
					$page->mainContent = "Die angeforderte Aktion lieferte keine Ergebnisse zurück.";
					$page->title = "Keine Ergebnisse";
				}
			}
			else 
			{ 
				$page = new Page();
				$page->errorCode = 500;
				$page->errorMessage = "Die angeforderte Aktion konnte nicht ausgeführt werden.";
			}
			return $page;
		}
		else
		{
			$page = new Page();
			$page->errorCode = 404;
			$page->title = "TestEnv error";
			return $page;
		}
	}
}