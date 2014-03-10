<?php
class Page
{
	public function addCssFile($file)
	{
		$this->cssFiles[] = $file;
	}
	
	public function getCssFiles()
	{
		$files = array();
		foreach ($this->cssFiles as $cssFile) {
			$files[] = sprintf("\t<link rel='stylesheet' href='%s'>\n", $cssFile);
		}
		return $files;
	}
	
	public function addMeta($key, $value, $type)
	{
		$this->metaInfo[$key] = array("content" => $value, "type" => $type);
	}
	
	public function getMeta()
	{
		$meta = array();
		foreach ($this->metaInfo as $k => $val) {
			$meta[] = sprintf("<meta %s='%s' content='%s'>\n", $val['type'], $k, $val['content']);
		}
		return $meta;
	}
	
	public function addJSString($js_string)
	{
		$this->js_strings[] = $js_string;
	}
	
	public function addJSFile($js_path)
	{
		$this->js_files[] = $js_path;
	}
	
	public function getJSStrings()
	{
		$code = "";
		foreach($this->js_strings as $js_str)
		{
			$code .= "\t" . '<script type="text/javascript">';
			$code .= $js_str;
			$code .= '</script>' . "\n\t";
		}
		return $code;
	}
	
	public function getJSFiles()
	{
		$code = "";
		foreach ($this->js_files as $js_file)
		{
			$code .= "\n\t" . '<script type="text/javascript" src="'. $js_file .'"></script>' . "\n";
		}
		return $code;
	}
	
	private $js_strings = array();
	private $js_files = array();
	private $cssFiles = array();
	private $metaInfo = array();
	public $title = "";
	public $mainContent = "";
	public $errorCode = 0;
	public $errorMessage = "";
}