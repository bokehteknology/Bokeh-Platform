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
* Log system class
*/
class log
{
	/**
	* Logging files
	*/
	private $files = array();

	/**
	* Files Handlers
	*/
	private $handlers = array();

	/**
	* Date/time format for logs
	*/
	private $date_format = 'd/m/Y H:i:s';

	/**
	* Constructor
	*/
	public function __construct()
	{
		global $root_path;

		$this->files = array(
			'errors'	=> $root_path . 'configs/error_log.txt',
			'standard'	=> $root_path . 'configs/standard_log.txt'
		);

		foreach($this->files as $type => $file)
		{
			$this->open($type, $file);
		}
	}

	/**
	* Open log file for writing
	*/
	public function open($type, $file)
	{
		$this->handlers[$type] = @fopen($file, 'ab');

		return (bool) $this->handlers[$type];
	}

	/**
	* Close log file for writing
	*/
	public function close($type)
	{
		return @fclose($this->handlers[$type]);
	}

	/**
	* Write log
	*
	* @return bool
	*/
	public function write($type, $message)
	{
		return (bool) @fwrite($this->handlers, ('[' . date($this->date_format) . '] ' . $message));
	}
}
