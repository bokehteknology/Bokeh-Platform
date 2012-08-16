<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_api_tests extends PHPUnit_Framework_TestCase
{
	private function _set_api_info()
	{
		global $_SERVER, $bokeh_version;

		$_SERVER['SERVER_NAME'] = 'pppX.worker.travis-ci.org';
		$bokeh_version = '0.0.0';

		if (!defined('APIKEY'))
		{
			# Apikey enabled only for 'bokeh_platform' service
			@define('APIKEY', 'f320c6951a30639ffaa584db47339008');
		}
	}

	# Do a API request
	public function test_do_request()
	{
		$this->_set_api_info();

		$request = api_request('bokeh_platform', 'dev');
		$request_status = (bool) $request;

		$this->assertTrue($request_status);

		if ($request_status && (!isset($request['news_type']) || $request['news_type'] != 0))
		{
			$this->assertTrue(isset($request['version']));
			$this->assertFalse(isset($request['error']));
		}
	}
}
