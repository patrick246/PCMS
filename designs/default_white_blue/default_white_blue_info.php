<?php
class default_white_blue_info implements DesignInfo
{
    public function getTemplateFile()
    {
        return 'main.tpl.php';
    }

    public function getPluginBoxes()
    {
        return array('sidebarBox1', 'sidebarBox2');
    }

    public function getErrorTemplateFile()
    {
        return 'error.tpl.php';
    }
}
