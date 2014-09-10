<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 07.09.14
 * Time: 16:31
 */

class mod_design_controller extends Controller {

	public function form()
	{
		$template = new Template($this->moduleBaseDir . 'templates/form.tpl.php');

		$design_directories_tmp = scandir(PATH_SUBDIR . 'designs/');
		$design_directories = array();
		foreach($design_directories_tmp as $dir)
		{
			if(is_dir(PATH_SUBDIR . 'designs/' . $dir) && $dir != '.' && $dir != '..')
			{
				$design_directories[] = $dir;
			}
		}

		$html = '';
		foreach($design_directories as $dir)
		{
			$tpl = new Template($this->moduleBaseDir . 'templates/form_entry.tpl.php');
			$tpl->set('name', $dir);
			$tpl->set('version', '1.0');
			$tpl->set('author', 'patrick246');
			$tpl->set('activated', true);

			$html .= $tpl->display();
		}
		$template->set('design_entries', $html, $template->getNoEscapeFunc());

		$page = new Page();
		$page->title = "Design auswählen";
		$page->mainContent = $template->display();
		return $page;
	}
} 