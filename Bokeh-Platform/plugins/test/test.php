<?php
/**
*
* @package plugin_test
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
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
	var $plugin_id = 'test';
	var $is_controller = true;
	var $load_lang = true;

	function plugin_test()
	{
		global $root_path;

		$this->template_dir = $root_path . 'plugins/' . $this->plugin_id . '/templates/';

		# here you can put some code for init your plugin
	}

	function index()
	{
		global $smarty;

		$smarty->assign('cfg_text', $this->config->text);

		page_header('PLUGIN_TEST_TITLE');
		$smarty->display($this->template_dir . 'home_body.tpl');
		page_footer();
	}
}
