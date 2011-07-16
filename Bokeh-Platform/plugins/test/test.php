<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_BOKEH'))
{
	exit;
}

class plugin_test
{
	var $is_controller = true;
	var $load_lang = true;

	function plugin_test()
	{
		global $root_path, $plugin_name;

		$this->template_dir = $root_path . 'plugins/' . $plugin_name . '/templates/';

		# here you can put some code for init your plugin
	}

	function index()
	{
		global $smarty;
	
		page_header('PLUGIN_TEST_TITLE');
		$smarty->display($this->template_dir . 'home_body.html');
		page_footer();
	}
}
