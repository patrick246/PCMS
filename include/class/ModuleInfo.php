<?php
interface ModuleInfo
{
	public function getName();
	public function getVersion();
	public function getAuthor();
	public function getDefaultMethod();
	public function getDefaultParams();
}