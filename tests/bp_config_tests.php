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
	# Write custom user configuration
	public function test_write()
	{
		$config = new config();

		$this->assertTrue($config->write());
	}

	# Read a value from system configuration
	public function test_sys_get()
	{
		$config = new config();

		$this->assertEquals('www.mysite.com', $config->sys->server_name);
	}

	# Change a system configuration value
	public function test_sys_update()
	{
		$config = new config();

		$config->sys->server_name = 'www.yoursite.com';

		$this->assertEquals('www.yoursite.com', $config->sys->server_name);
	}
}
