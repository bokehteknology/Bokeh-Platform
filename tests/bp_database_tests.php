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
		global $_ENV;

		$config = new config();
		$config->db->type = $_ENV['DB'];

		require($root_path . 'includes/database/' . $config->db->type . '.' . $phpEx);

		$database_class_name = 'database_' . $config->db->type;
		$this->db = new $database_class_name();

		switch($config->db->type)
		{
			case 'mysql':
				$config->db->host = 'localhost';
				$config->db->port = 3306;
				$config->db->name = 'bokeh_platform';
				$config->db->user = 'root';
				$config->db->pass = '';
				$config->db->prefix = '_bokeh';
				break;
		}

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
