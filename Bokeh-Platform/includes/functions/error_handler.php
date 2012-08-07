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
* Handle all error messages
*
* @param int $errno
* @param string $errstr
* @param string $errfile
* @param int $errline
* @return bool
*/
function error_handler($errno, $errstr, $errfile, $errline)
{
	global $root_path;

	$errfile = str_replace(realpath($root_path) . '/', '', $errfile);
	$msg = "<p><b>[Bokeh Debug] PHP %s</b>: <u>$errstr</u> in <b>$errfile</b> on line <b>$errline</b>.</p>";

	switch($errno)
	{
		case E_USER_ERROR:
			$msg = sprintf($msg, 'User Error');
			break;
		case E_USER_WARNING:
			$msg = sprintf($msg, 'User Warning');
			break;
		case E_USER_NOTICE:
			$msg = sprintf($msg, 'User Notice');
			break;
		case E_WARNING:
			$msg = sprintf($msg, 'Warning');
			break;
		case E_ERROR:
			$msg = sprintf($msg, 'Error');
			break;
		case E_PARSE:
			$msg = sprintf($msg, 'Parse');
			break;
		case E_NOTICE:
			if (!defined('DEBUG') || !DEBUG)
			{
				return true;
			}

			$msg = sprintf($msg, 'Notice');
			break;
		default:
			$msg = sprintf($msg, "[$errno]");
			break;
	}

	error_box($msg, array(), 'PHP Error');
}
