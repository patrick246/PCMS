#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 08.09.14
 * Time: 19:12
 */

/*
 * Platzhalter Modul
 * {{name}} => Name des Moduls
 * {{default_method}} => Name of the default method
 * {{default_parameter_list}} => comma separated list of params
 *
 * {{full_name}} => Full name for info file
 * {{author}} => Name of the author
 * {{default_params}} => Values of {{default_parameter_list}}
 */


if(php_sapi_name() != 'cli')
{
	die("pcms_helper should only be called on command line!");
}

chdir(realpath(dirname(__FILE__) . '/../'));
echo "Working in " . getcwd() . "\n";

if(isset($argv[1]) && $argv[1] == 'module')
{
	// Name
	if(!isset($argv[2]))
	{
		echo 'Name [a-zA-Z_]: ';
		$name = readline();
	}
	else
	{
		$name = $argv[2];
	}

	// Admin (true|false)
	if(!isset($argv[3]))
	{
		echo 'Admin [true|false|y|j|n]: ';
		$input = readline();
		switch($input)
		{
			case 'true':
			case 'y':
			case 'j':
				$admin = true;
				break;
			case 'false':
			case 'n':
				$admin = false;
				break;
			default:
				echo "was?\n";
				die();
		}

	}
	else
	{
		switch($argv[2])
		{
			case 'true':
			case 'y':
			case 'j':
				$admin = true;
				break;
			case 'false':
			case 'n':
				$admin = false;
				break;
			default:
				echo "was?\n";
				die();
		}
	}

	// Full name
	echo "Full name: ";
	$full_name = readline();

	// Author
	echo "Author: ";
	$author = readline();

	// Default method
	echo "Default method name: ";
	$default_method = readline();

	// Default method parameter list
	echo "Default method parameter list (comma separated): ";
	$default_method_param_list = readline();

	// Default method parameter values
	echo "Default method parameter values (comma separated): ";
	$default_method_param_values = readline();

	if($admin)
	{
		$newDirectory = '/administrator/modules';
	}
	else
	{
		$newDirectory = '/modules';
	}

	$replacements = array(
		'{{name}}' => $name,
		'{{default_method}}' => $default_method,
		'{{default_parameter_list}}' => $default_method_param_list,
		'{{default_params}}' => $default_method_param_values,
		'{{full_name}}' => $full_name,
		'{{author}}' => $author,


		'/.directory_templates/'. $argv[1] => $newDirectory
	);

	$originalTree = getTree($argv[1]);
	$tree = str_replace(array_keys($replacements), array_values($replacements), $originalTree);
	copyArray($originalTree, $tree, getcwd() . $newDirectory, function($file) use ($replacements) {
		file_put_contents($file, str_replace(array_keys($replacements), array_values($replacements), file_get_contents($file)));
	});
}
elseif(isset($argv[1]) && $argv[1] == 'design')
{

}
elseif(isset($argv[1]) && $argv[1] == 'plugin')
{

}
elseif(isset($argv[1]))
{
	echo "Unrecognized option: " . $argv[1] . "\n";
}
else
{
	echo "Usage: pcms_helper.php [module|template|plugin]\n";
}


function getTree($dirname)
{
	$tree = array();
	$directory = getcwd() . "/.directory_templates/$dirname/";
	$directory_iterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
	$directory_iterator_iterator = new RecursiveIteratorIterator($directory_iterator, RecursiveIteratorIterator::SELF_FIRST);

	if($directory_iterator_iterator->valid())
	{
		$directory_iterator_iterator->next();
	}
	while($directory_iterator_iterator->valid())
	{
		if(!$directory_iterator_iterator->isDot())
		{
			$tree[] = $directory_iterator_iterator->getPath() . '/' . $directory_iterator_iterator->getFilename();
		}
		$directory_iterator_iterator->next();
	}
	return $tree;
}

function copyArray($originalTree, $tree, $to, $file_func)
{
	if(count($originalTree) != count($tree))
		die('Error: Tree size mismatch');

	for($i = 0; $i < count($tree); $i++)
	{
		if(is_dir($originalTree[$i]))
		{
			mkdir($tree[$i]);
		}
		else
		{
			copy($originalTree[$i], $tree[$i]);
			$file_func($tree[$i]);
		}
	}
}