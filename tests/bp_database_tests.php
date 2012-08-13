<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_database_tests extends PHPUnit_Framework_TestCase
{
	private $db;

	private function _start()
	{
		global $_SERVER, $root_path, $phpEx;

		$config = new config();

		$config->db->type = $_SERVER['BP_DB_TYPE'];		
		$config->db->host = $_SERVER['BP_DB_HOST'];
		$config->db->port = $_SERVER['BP_DB_PORT'];
		$config->db->name = $_SERVER['BP_DB_NAME'];
		$config->db->user = $_SERVER['BP_DB_USER'];
		$config->db->pass = $_SERVER['BP_DB_PASS'];
		$config->db->prefix = '_bokeh';

		require($root_path . 'includes/database/' . $config->db->type . '.' . $phpEx);

		$database_class_name = 'database_' . $config->db->type;
		$this->db = new $database_class_name();

		return $this->db->sql_connect($config->db->host, $config->db->port, $config->db->user, $config->db->pass, $config->db->name);
	}

	private function _stop()
	{
		return $this->db->sql_close();
	}

	# Test database connection
	public function test_load()
	{
		$this->assertTrue($this->_start());
		$this->assertTrue($this->_stop());
	}
}
