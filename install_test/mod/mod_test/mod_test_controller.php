<?php
class mod_test_controller extends Controller
{
	public function __construct(&$app)
	{
		parent::__construct($app);
	}
	
	public function defaultMethod()
	{
		$page = new Page();
		$page->mainContent = "test";
		return $page;
	}
}