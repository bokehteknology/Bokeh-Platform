<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_plugin_tests extends PHPUnit_Framework_TestCase
{
	private $u_plugin = 'test';
	private $u_class = 'plugin_test';

	# Load all plugins
	public function test_load_all()
	{
		global $config, $plugin_controllers_list, $plugins, $client_lang, $plugin_name;

		$config = new bp_config();

		$plugin_controllers_list = array();
		$plugins = new stdClass();

		$client_lang = 'en';
		$plugin_name = $this->u_plugin;

		$this->assertTrue(load_plugins());

		$plugins->$plugin_name->_configure();

		$this->assertTrue($plugins->$plugin_name->is_controller);

		$this->assertTrue(run_plugin($plugin_name, 'index', $plugin_controllers_list));
	}

	# Load test plugin
	public function test_load_test()
	{
		global $root_path, $phpEx;

		if (!class_exists($this->u_class))
		{
			include($root_path . 'plugins/' . $this->u_plugin . '/' . $this->u_plugin . '.' . $phpEx);
		}

		$plugin = new $this->u_class();
		$plugin->_configure(); 

		$this->assertTrue($plugin->is_controller);
		$this->assertTrue($plugin->load_lang);
	}
}
