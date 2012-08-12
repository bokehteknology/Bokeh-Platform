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
	public function test_sys_read()
	{
		global $config;

		$this->assertEquals('www.mysite.com', $config->sys->server_name);
	}
}
