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
	private $db, $config;

	private function _start()
	{
		global $_SERVER, $root_path, $phpEx;

		$this->config = new bp_config();

		$this->config->db->type = $_SERVER['BP_DB_TYPE'];		
		$this->config->db->host = $_SERVER['BP_DB_HOST'];
		$this->config->db->port = $_SERVER['BP_DB_PORT'];
		$this->config->db->name = $_SERVER['BP_DB_NAME'];
		$this->config->db->user = $_SERVER['BP_DB_USER'];
		$this->config->db->pass = $_SERVER['BP_DB_PASS'];
		$this->config->db->prefix = 'bokeh_';

		$database_class_name = 'database_' . $this->config->db->type;
		$this->db = new $database_class_name();

		return $this->db->sql_connect($this->config->db->host, $this->config->db->port, $this->config->db->user, $this->config->db->pass, $this->config->db->name);
	}

	private function _stop()
	{
		return $this->db->sql_close();
	}

	private function _load_schema()
	{
		$sql = array();

		$sql[] = "CREATE TABLE IF NOT EXISTS %prefix%test (id int(11) NOT NULL AUTO_INCREMENT, value text NOT NULL, PRIMARY KEY (id)) TYPE=InnoDB AUTO_INCREMENT=1;";
		$sql[] = "INSERT INTO %prefix%test (id, value) VALUES (NULL, 'abc');";

		foreach($sql as $query)
		{
			$this->db->sql_query(str_replace('%prefix%', $this->config->db->prefix, $query));
		}
	}

	private function _drop_tables()
	{
		$tables = array();

		$tables[] = 'test';

		foreach($tables as $table)
		{
			$this->db->sql_query("DROP TABLE {$this->config->db->prefix}{$table}");
		}
	}

	# Test database connection
	public function test_load()
	{
		$this->assertTrue($this->_start());

		$this->_load_schema();
		$this->_drop_tables();

		$this->assertTrue($this->_stop());
	}

	# SELECT
	public function test_select()
	{
		$this->_start();
		$this->_load_schema();

		$result = $this->db->sql_query("SELECT * FROM {$this->config->db->prefix}test WHERE value = 'abc' LIMIT 0,1");
		$data = $this->db->sql_fetch($result);

		$this->assertEquals($this->db->sql_affectedrows($result), 1);

		$this->assertEquals('abc', $data['value']);

		$this->_drop_tables();
		$this->_stop();
	}

	# UPDATE
	public function test_update()
	{
		$this->_start();
		$this->_load_schema();

		$this->db->sql_query("UPDATE {$this->config->db->prefix}test SET value = 'test' WHERE value = 'abc'");

		$result = $this->db->sql_query("SELECT * FROM {$this->config->db->prefix}test WHERE value = 'test' LIMIT 0,1");

		$this->assertEquals($this->db->sql_affectedrows($result), 1);

		$this->_drop_tables();
		$this->_stop();
	}

	# INSERT
	public function test_insert()
	{
		$this->_start();
		$this->_load_schema();

		$this->db->sql_query("INSERT INTO {$this->config->db->prefix}test (id, value) VALUES (NULL, 'def')");

		$result = $this->db->sql_query("SELECT * FROM {$this->config->db->prefix}test WHERE value = 'def' LIMIT 0,1");

		$this->assertEquals($this->db->sql_affectedrows($result), 1);

		$this->_drop_tables();
		$this->_stop();
	}
}
