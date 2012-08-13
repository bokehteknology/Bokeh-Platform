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

	# Load plugin
	public function test_load()
	{
		global $root_path, $phpEx;

		include($root_path . 'plugins/' . $this->u_plugin . '/' . $this->u_plugin . '.' . $phpEx);

		$plugin = new $this->u_class();
		$plugin->_configure(); 

		$this->assertTrue($plugin->is_controller);
		$this->assertTrue($plugin->load_lang);
	}
}
