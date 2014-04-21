<?php
function generateAccessDeniedPage()
{
	$page = new Page();
	$page->errorCode = 401;
	$page->errorMessage = "Du hast nicht genügend Berechtigungen um diese Aktion auszuführen.";
	return $page;
}

function generateInvalidTokenPage()
{
	$page = new Page();
	$page->errorCode = 401;
	$page->errorMessage = "Das Sicherheitstoken ist abgelaufen oder ungültig.";
	return $page;
}

function generateResourceNotFoundPage()
{
	$page = new Page();
	$page->errorCode = 404;
	$page->errorMessage = "Die angegebene Ressource wurde nicht gefunden.";
	return $page;
}
