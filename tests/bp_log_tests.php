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
	# Log loading test
	public function test_load()
	{
		$log = new log();

		$log->close('errors');
		$log->close('standard');

		$this->assertTrue($log->open('errors', $root_path . 'configs/error_log.txt'));
		$this->assertTrue($log->close('errors'));
	}

	# Write to log
	public function test_write_log()
	{
		$log = new log();

		$this->assertTrue($log->write('errors', 'Testing error'));
		$this->assertTrue($log->write('standard', 'Testing standard log message'));
	}
}
