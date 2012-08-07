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

class plugin_test extends plugin
{
	public $plugin_id = 'test';

	function _configure()
	{
		$this->is_controller = true;
		$this->load_lang = true;

		# here you can put some code for init your plugin
	}

	function index()
	{
		$this->plugin->assign('cfg_text', $this->config->text);

		$this->plugin->view_header('PLUGIN_TEST_TITLE');
		$this->plugin->view('home_body');
		$this->plugin->view_footer();
	}
}
