<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_log_tests extends PHPUnit_Framework_TestCase
{
	# Write to log (RotatingFileHandler)
	public function test_write_rotatingfile()
	{
		$log = new bp_log('log_test');
		$log->pushHandler('RotatingFile', array('./Bokeh-Platform/logs/RotatingFileHandler.txt', 0));

		$this->assertTrue($log->write('info', 'testing logging'));
	}

	# Write to log (StreamHandler)
	public function test_write_stream()
	{
		$log = new bp_log('log_test');
		$log->pushHandler('Stream', array('./Bokeh-Platform/logs/StreamHandler.txt'));

		$this->assertTrue($log->write('info', 'testing logging'));
	}

	# Write to log (SyslogHandler)
	public function test_write_syslog()
	{
		$log = new bp_log('log_test');
		$log->pushHandler('Syslog', array('SyslogHandler', 'local6'));

		$this->assertTrue($log->write('info', 'testing logging'));
	}
}
