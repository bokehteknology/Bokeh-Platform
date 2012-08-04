<?php
/**
*
* @package BokehPlatform
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
* Config class
*/
class config
{
	/**
	* System configuration
	*/
	public $sys;

	/**
	* Database configuration
	*/
	public $db;

	/**
	* Custom user configuration
	*/
	public $usr;

	/**
	* Database tables configuration
	*/
	public $tables;

	/**
	* Constructor (read all configs)
	*/
	public function config()
	{
		global $root_path, $phpEx;

		$this->sys = $this->read('system', false);
		$this->db = $this->read('database', false);
		$this->usr = $this->read('user', true);

		$this->constants();

		if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
		{
			$this->tables = $this->read('db_tables', false);
		}

		if (defined('ENABLE_PLUGINS') && ENABLE_PLUGINS)
		{
			if (strpos($this->sys->plugins, '|'))
			{
				$this->sys->plugins = explode('|', $this->sys->plugins);
			}
			else
			{
				$this->sys->plugins = array($this->sys->plugins);
			}
		}
	}

	/**
	* Define application constants
	*/
	private function constants()
	{
		@define('APIKEY', (isset($this->sys->apikey) ? $this->sys->apikey : ''));
		@define('DEBUG', ((isset($this->sys->debug) && is_bool($this->sys->debug)) ? $this->sys->debug : false));
		@define('DISPLAY_RAM', ((isset($this->sys->display_ram) && is_bool($this->sys->display_ram)) ? $this->sys->display_ram : false));
		@define('ERROR_HANDLER', ((isset($this->sys->error_handler) && is_bool($this->sys->error_handler)) ? $this->sys->error_handler : true));
		@define('EXPLAIN_MODE', ((isset($this->sys->explain_mode) && is_bool($this->sys->explain_mode)) ? $this->sys->explain_mode : false));
		@define('EXPLAIN_MODE_PASSKEY', (isset($this->sys->explain_mode_passkey) ? $this->sys->explain_mode_passkey : ''));
		@define('ENABLE_DATABASE', ((isset($this->sys->enable_database) && is_bool($this->sys->enable_database)) ? $this->sys->enable_database : false));
		@define('ENABLE_PLUGINS', ((isset($this->sys->enable_plugins) && is_bool($this->sys->enable_plugins)) ? $this->sys->enable_plugins : true));

		unset($this->sys->apikey);
		unset($this->sys->debug);
		unset($this->sys->display_ram);
		unset($this->sys->error_handler);
		unset($this->sys->explain_mode);
		unset($this->sys->explain_mode_passkey);
		unset($this->sys->enable_database);
		unset($this->sys->enable_plugins);
	}

	/**
	* Load plugin configuration
	*
	* @param string $plugin_id identificator of plugin
	* @return object object of loaded configuration
	*/
	public function load_plugin_cfg($plugin_id)
	{
		return $this->read('plugins/' . $plugin_id, true);
	}

	/**
	* Read a file configuration
	*
	* @param string $file
	* @param bool $sections
	* @return object readed configuration
	*/
	private function read($file, $sections = false)
	{
		global $root_path, $phpEx;

		$cfg = parse_ini_file($root_path . 'configs/' . $file . '.cfg', $sections);

		return $this->toObject($cfg);
	}

	/**
	* Write custom user file configuration (configs/user.cfg)
	*
	* @return bool
	*/
	public function write()
	{
		global $root_path, $phpEx;

		$handle = @fopen($root_path . 'configs/user.cfg', 'wb');

		if (!$handle)
		{
			die("Could not write on configs/user.cfg");
		}

		fwrite($handle, "; Bokeh Platform - User Configuration\n");
		fwrite($handle, "; Last update: " . date('d-m-Y H:i:s') . "\n\n");

		foreach($this->toArray($this->usr) as $key => $value)
		{
			if (is_array($value))
			{
				fwrite($handle, "\n\n[{$key}]\n");
			}
			else
			{
				fwrite($handle, "{$key} = {$value}\n");
			}
		}

		fclose($handle);

		return true;
	}

	/**
	* Transform array to object
	*
	* @param array $array
	* @return object object converted from array
	*/
	private function toObject($array)
	{
		$object = new stdClass();

		foreach($array as $key => $value)
		{
			if (is_array($value))
			{
				if (count($value) > 0)
				{
					$object->$key = $this->toObject($value);
				}
				else
				{
					$object->$key = new stdClass();
				}
			}
			else
			{
				$object->$key = $this->parseValue($value, false);
			}
		}

		return $object;
	}

	/**
	* Transform object to array
	*
	* @param object $object
	* @return array array converted from object
	*/
	private function toArray($object)
	{
		$array = array();

		foreach(get_object_vars($object) as $key => $value)
		{
			if (is_object($value))
			{
				if (count($value) > 0)
				{
					$array[$key] = $this->toArray($value);
				}
				else
				{
					$array[$key] = array();
				}
			}
			else
			{
				$array[$key] = $this->parseValue($value, true);
			}
		}

		return $array;
	}

	/**
	* Parse a string value in correct type
	* Parse only boolean and integer (float as int)
	*
	* If there are none of the that types it returns as a string
	*
	* @param string $value
	* @param bool $to_cfg
	* @return mixed parsed value
	*/
	private function parseValue($value, $to_cfg = false)
	{
		if ($to_cfg)
		{
			if ($value === true)
			{
				return '"true"';
			}
			else if ($value === false)
			{
				return '"false"';
			}
			else if (is_numeric($value))
			{
				return $value;
			}

			return '"' . $value . '"';
		}
		else
		{
			if (is_numeric($value))
			{
				return (int) $value;
			}
			else if ($value == 'true')
			{
				return true;
			}
			else if ($value == 'false')
			{
				return false;
			}

			return (string) $value;
			
		}
	}
}
