<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_functions_tests extends PHPUnit_Framework_TestCase
{
	# formtasize()
	public function test_formatsize()
	{
		$this->assertEquals('1 KB', formatsize(1024));
		$this->assertEquals('1 MB', formatsize(1048576));
		$this->assertEquals('1 GB', formatsize(1073741824));
	}

	# formatdate()
	public function test_formatdate()
	{
		global $config, $lang;

		$config = new config();
		$lang = array('MONTH_1' => 'January');

		date_default_timezone_set($config->sys->timezone);

		$this->assertEquals('January', formatdate(21600));
	}

	# formattime()
	public function test_formattime()
	{
		global $config;

		$config = new config();
		$time = time();

		date_default_timezone_set($config->sys->timezone);

		$this->assertEquals(date('H:i', $time), formatdate($time));
	}
}
