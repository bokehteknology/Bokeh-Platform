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
		$this->assertEquals('1.00 KB', formatsize(1024));
		$this->assertEquals('1.00 MB', formatsize(1048576));
		$this->assertEquals('1.00 GB', formatsize(1073741824));
	}

	# formatdate()
	public function test_formatdate()
	{
		global $config, $lang;

		$config = new config();
		$lang = array('MONTH_1' => 'January');

		date_default_timezone_set($config->sys->timezone);

		$this->assertEquals('1 January 1970', formatdate(21600));
	}

	# formathour()
	public function test_formathour()
	{
		global $config;

		$config = new config();
		$time = time();

		date_default_timezone_set($config->sys->timezone);

		$this->assertEquals(date('H:i', $time), formathour($time));
	}
}
