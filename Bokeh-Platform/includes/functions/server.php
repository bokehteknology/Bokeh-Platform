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
* Check if a $_REQUEST var is set, and output true/false vars passed to it
*
* @param string $var request var to check
* @param mixed $is_true value to return if is set
* @param mixed $is_false value to return if is not set
* @return mixed
*/
function request_var($var, $is_true = true, $is_false = false)
{
	global $_REQUEST;

	return (isset($_REQUEST[$var])) ? $is_true : $is_false;
}

/**
* Set correct status header
*
* @param int $code header status code
* @param string $message header status message
* @return bool
*/
function set_header_status($code, $message = '')
{
	global $_SERVER, $root_path, $phpEx, $controller;

	if (isset($_SERVER['HTTP_VERSION']))
	{
		$http = $_SERVER['HTTP_VERSION'];
	}
	else
	{
		$http = 'HTTP/1.0';
	}

	if (substr(strtolower(@php_sapi_name()), 0, 3) === 'cgi')
	{
		$http = 'Status:';
	}

	if (empty($message))
	{
		switch($code)
		{
			case 403:
				$message = 'Forbidden';
				break;
			case 404:
				$message = 'Not Found';
				break;
			default:
				# By default we send HTTP 404
				$code = 404;
				$message = 'Not Found';
				break;
		}

		if (isset($controller))
		{
			unset($controller);
		}

		if (file_exists($root_path . 'controllers/http_' . $code . '.' . $phpEx))
		{
			include($root_path . 'controllers/http_' . $code . '.' . $phpEx);

			$controller_class_name = 'controller_http_' . $code;

			$controller = new $controller_class_name();
			$controller->index();
		}
	}

	header($http . ' ' . $code . ' ' . $message, true, $code);

	# If we are at this point is because
	# header() have not send header to user
	return false;
}

/**
* Retrive request vars and add to array
*
* @param array $requests
* @return array
*/
function retrive_requests_vars($requests)
{
	return $requests;
}

/**
* Dispatch URL
*/
function dispatch_url()
{
	global $_GET, $config;

	if (!isset($_GET['url']))
	{
		$_GET['url'] = '';
	}

	$uri = trim($_GET['url'], '/');
	$uri = explode('/', $uri);

	$config->sys->url_controller = (isset($uri[0]) && !empty($uri[0])) ? $uri[0] : $config->sys->default_controller;
	$config->sys->url_page = (isset($uri[1]) && !empty($uri[1])) ? $uri[1] : 'index';
	$conifg->sys->url_params = array_slice($uri, 2);
}
