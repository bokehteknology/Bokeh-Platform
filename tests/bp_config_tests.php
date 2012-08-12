<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_config_tests extends PHPUnit_Framework_TestCase
{
	public function test_convert_to_object()
	{
		$config = new config();

		$config->read('database', false);

		$this->assertTrue(isset($config->db->type));
	}

	public function test_sys_get()
	{
		$config = new config();

		$this->assertEquals('www.mysite.com', $config->sys->server_name);
	}

	public function test_sys_update()
	{
		$config = new config();

		$config->sys->server_name = 'www.yoursite.com';

		$this->assertEquals('www.yoursite.com', $config->sys->server_name);
	}
}
