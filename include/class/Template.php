<?php
class Template
{
	public function __construct($path)
	{
		if(isset(self::$overrides[$path]))
		{
			$this->path = self::$overrides[$path];
		} 
		else 
		{
			$this->path = $path;
		}
		
		$this->builtin_escape_func = function($elem)
		{
			return htmlentities($elem, ENT_QUOTES);
		};
		$this->builtin_array_escape_func = function($arr)
		{
			foreach ($arr as &$elem) {
				htmlentities($elem, ENT_QUOTES);
			}
			return $arr;
		};
		$this->builtin_no_escape_func = function($elem)
		{
			return $elem;
		};
		
		$this->set('root', '/' . Config::SUBDIR . '/');
		
	}
	
	public function set($key, $value, callable $escape = null)
	{
		if(is_null($escape))
		{
			if(is_array($value))
				$escape = $this->getArrayEscapeFunc();
			else
				$escape = $this->getDefaultEscapeFunc();
		}
		
		
		$this->placeholders[$key] = $escape($value); 
	}
	
	public function display()
	{
		if(file_exists($this->path))
		{
			extract($this->placeholders, EXTR_PREFIX_ALL, 'tpl');
			ob_start();
			require $this->path;
			$content = ob_get_clean();
			return $content;
		}
		else
		{
			trigger_error("Template does not exist: " . $this->path, E_USER_ERROR);
		}
	}
	
	public function getDefaultEscapeFunc()
	{
		return $this->builtin_escape_func;
	}
	
	public  function getArrayEscapeFunc()
	{
		return $this->builtin_array_escape_func;
	}
	
	public function getNoEscapeFunc() {
		return $this->builtin_no_escape_func;
	}
	
	public static function addOverwrite($original, $new)
	{
		if(!file_exists($new))
		{
			trigger_error("Template override does not exist", E_USER_ERROR);
		}
		self::$overrides[$original] = $new;
	}
	
	private $path;
	/**
	 * Placeholders that will be replaced
	 * @var array
	 */
	private $placeholders = array();
	
	private $builtin_escape_func;
	
	private $builtin_array_escape_func;
	
	private $builtin_no_escape_func;
	
	private static $overrides = array();
}