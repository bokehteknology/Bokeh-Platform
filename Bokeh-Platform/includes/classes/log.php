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
* Libraries used:
*   - monolog/monolog
*/
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;

/**
* Log system class
*
* Our interface for Monolog
*/
class bp_log
{
	/**
	* Logger
	*
	* @var Logger
	*/
	private $logger;

	/**
	* Logger Handlers
	*
	* @var array
	*/
	private $handlers = array();

	/**
	* Handers ID
	*
	* @var int
	*/
	private $handlers_id = 0;

	/**
	* Constructor
	*
	* @param string $channel Name for the logger channel
	*/
	public function __construct($channel)
	{
		$this->logger = new Logger($channel);
	}

	/**
	* Add handler to the logger channel
	*
	* @param string $type Handler type
	* @param string $file File used for StreamHandler
	* @return int Key of handlers array
	*/
	public function pushHandler($type, $params = array())
	{
		switch($type)
		{
			/**
			* 0 - Filename
			* 1 - Max files
			* 2 - Level
			*/
			case 'RotatingFile':
				$params[2] = isset($params[2]) ? $params[2] : Logger::DEBUG;

				$this->handlers[$this->handlers_id] = new RotatingFileHandler($params[0], $params[1], $params[2]);
			break;

			/**
			* 0 - Filename
			* 1 - Level
			*/
			case 'Stream':
				$params[1] = isset($params[1]) ? $params[1] : Logger::DEBUG;

				$this->handlers[$this->handlers_id] = new StreamHandler($params[0], $params[1]);
			break;

			/**
			* 0 - Ident
			* 1 - Facility
			* 2 - Level
			*/
			case 'Syslog':
				$params[1] = isset($params[1]) ? $params[1] : LOG_USER;
				$params[2] = isset($params[2]) ? $params[2] : Logger::DEBUG;

				$this->handlers[$this->handlers_id] = new SyslogHandler($params[0], $params[1], $params[2]);
			break;
		}

		$this->logger->pushHandler($this->handlers[$this->handlers_id]);

		$this->handlers_id++;

		return ($this->handlers_id - 1);
	}

	/**
	* Write log
	*
	* @param string $level Log level
	* @param string $message Log message
	* @return bool
	*/
	public function write($level, $message, $context = array())
	{
		switch($level)
		{
			case 'error':
				$write = $this->logger->addError($message, $context);
			break;

			case 'info':
				$write = $this->logger->addInfo($message, $context);
			break;

			default:
				$write = $this->logger->addWarning($message, $context);
			break;
		}

		return (bool) $write;
	}
}
