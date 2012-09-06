<?php
/**
*
* @package database
* @copyright (c) 2012 Bokeh Teknology
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
*/
class database_mysql
{
	/**
	* Number of executed SQL queries
	*/
	var $sql_queries = 0;

	/**
	* Time spent on execution of SQL queries
	*/
	var $time_on_sql = 0;

	/**
	* Array with a list of SQL queries executed for explain mode
	*/
	var $sql_reports = array();

	/**
	* Initialize MySQL class
	*/
	function __construct()
	{
		# Nothing for now
	}

	/**
	* Connect to MySQL
	*
	* @param string $dbhost database host
	* @param int $dbport database port
	* @param string $dbuser database user
	* @param string $dbpass database user password
	* @param string $dbname database name
	* @return mixed connection link
	*/
	function sql_connect($dbhost, $dbport, $dbuser, $dbpass, $dbname)
	{
		global $bp;

		$dbhost = (empty($dbhost) ? 'localhost' : $dbhost) . ':' . $dbport;
		$dbuser = empty($dbuser) ? 'root' : $dbuser;

		if (($this->db_connect_id = @mysql_connect($dbhost, $dbuser, $dbpass)) === false)
		{
			$bp->log->write('error', "Could not connect to database server: {$dbhost} || Error: " . mysql_error(), array('dbal' => 'mysql'));

			error_box('ERR_SQL_CONNECT', array($dbhost));
		}
		else
		{
			if (!@mysql_select_db($dbname, $this->db_connect_id))
			{
				$bp->log->write('error', "Can't select the database: {$dbname} || Error: " . mysql_error(), array('dbal' => 'mysql'));

				error_box('ERR_SQL_SELECT_DB', array($dbname));
			}
			else
			{
				return true;
			}
		}
	}

	/**
	* Close an open MySQL connection
	*
	* @return bool
	*/
	function sql_close()
	{
		return @mysql_close($this->db_connect_id);
	}

	/**
	* Run a SQL query
	*
	* @param string $query
	* @return mixed query executed
	*/
	function sql_query($query = '')
	{
		global $starttime, $bp;

		if ($query != '')
		{
			$start_sql = explode(' ', microtime());
			$start_sql = $start_sql[1] + $start_sql[0];

			if (($this->query_result = @mysql_query($query, $this->db_connect_id)) === false)
			{
				$db_error = mysql_error();

				$bp->log->write('error', "There was an error executing the query: \"{$query}\" || Error: \"{$db_error}\"", array('dbal' => 'mysql'));

				error_box('ERR_SQL_QUERY', array($query, $db_error));
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
	* @return array fetched query
	*/
	function sql_fetch()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? @mysql_fetch_assoc($this->query_result) : false;
	}

	/**
	* Return number of affected rows
	*
	* @return int number of affected rows
	*/
	function sql_affectedrows()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? mysql_affected_rows($this->db_connect_id) : false;
	}

	/**
	* Free all memory associated of last query
	*
	* @return bool
	*/
	function sql_free_result()
	{
		if (!isset($this->query_result)) error_box('ERR_SQL_NO_QUERY');

		return $this->db_connect_id ? mysql_free_result($this->query_result) : false;
	}

}
