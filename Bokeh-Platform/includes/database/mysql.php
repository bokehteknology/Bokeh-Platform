<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

/**
* @ignore
*/
if (!defined('IN_BOKEH'))
{
	exit;
}

/**
* MySQL class
*
*/
class database_mysql
{
	var $sql_queries = 0;
	var $time_on_sql = 0;
	var $sql_reports = array();

	/**
	* Initialize MySQL class
	*
	*/
	function database_mysql()
	{
		# Nothing for now
	}

	/**
	* Connect to MySQL
	*
	* @param $dbhost string
	* @param $dbport int
	* @param $dbuser string
	* @param $dbpass string
	* @param $dbname string
	*/
	function sql_connect($dbhost, $dbport, $dbuser, $dbpass, $dbname)
	{
		if ($dbhost == '') $dbhost = 'localhost';
		if ($dbport != '') $dbhost .= ':' . $dbport;
		if ($dbuser == '') $dbuser = 'root';

		if (($this->db_connect_id = @mysql_connect($dbhost, $dbuser, $dbpass)) === false)
		{
			error_box('ERR_SQL_CONNECT', array($dbhost));
		}
		else
		{
			if (!@mysql_select_db($dbname, $this->db_connect_id))
			{
				error_box('ERR_SQL_SELECT_DB', array($dbname));
			}
			else
			{
				return $this->db_connect_id;
			}
		}
	}

	/**
	* Close an open MySQL connection
	*
	*/
	function sql_close()
	{
		return @mysql_close($this->db_connect_id);
	}

	/**
	* Run a SQL query
	*
	* @param $query string
	*/
	function sql_query($query = '')
	{
		global $starttime;

		if ($query != '')
		{
			$start_sql = explode(' ', microtime());
			$start_sql = $start_sql[1] + $start_sql[0];

			if (($this->query_result = @mysql_query($query, $this->db_connect_id)) === false)
			{
				error_box('ERR_SQL_QUERY', array($query, mysql_error()));
			}

			$finish_sql = explode(' ', microtime());
			$finish_sql = $finish_sql[0] + $finish_sql[1];

			$this->time_on_sql += $finish_sql - $start_sql;
			$this->sql_reports[] = array('query' => $query, 'before' => ($start_sql - $starttime), 'after' => ($finish_sql - $starttime), 'elapsed' => ($finish_sql - $start_sql));

			$this->sql_queries++;
			return $this->query_result;
		}
		else
		{
			error_box('ERR_SQL_NO_QUERY');
		}

		return false;
	}

	/**
	* Fetch the last executed query
	*
	*/
	function sql_fetch()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? @mysql_fetch_assoc($this->query_result) : false;
	}

	/**
	* Return number of affected rows
	*
	*/
	function sql_affectedrows()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? mysql_affected_rows($this->db_connect_id) : false;
	}

	/**
	* Free all memory associated of last query
	*
	*/
	function sql_free_result()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? mysql_free_result($this->query_result) : false;
	}

}

$__database_name__ = 'MySQL';
