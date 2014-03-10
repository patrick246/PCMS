<?php
function varDump($o)
{
	ob_start();
	echo "<pre>";
	var_dump($o);
	echo "</pre>";
	return ob_get_clean();
}