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
* Print page header
*
* @param string $title title of the page
* @return bool
*/
function page_header($title = false)
{
	global $lang, $smarty;

	if ($title !== false && $title == strtoupper($title) && isset($lang[$title]))
	{
			$smarty->assign('title', $lang[$title]);
	}
	else if ($title !== false)
	{
			$smarty->assign('title', $title);
	}

	_template('header');

	return true;
}

/**
* Print page footer
*
* @return bool
*/
function page_footer()
{
	_template('footer');
	close(false);

	return true;
}

/**
* Print a template
*
* @param string $tpl_file template filename
* @param bool $template if true it specific that the template is in a template subdirectory
* @return bool
*/
function _template($tpl_file, $_template = true)
{
	global $config, $smarty;

	output_debug();

	if ($_template)
	{
		$smarty->display($config->sys->template . '/' . $tpl_file . '.tpl');
	}
	else
	{
		$smarty->display($tpl_file . '.tpl');
	}

	return true;
}

/**
* Assign to Smarty general vars
*
* @return bool
*/
function smarty_assign()
{
	global $lang, $smarty;

	$smarty->assign(array(
		'current_year'	=> date('Y', time())
	));

	$_lang = array();

	foreach($lang as $key => $val)
	{
		$_lang[strtolower($key)] = $val;
	}

	$smarty->assign('lang', $_lang);

	return true;
}

/**
* Generate debug info
*
* @return bool
*/
function output_debug()
{
	global $smarty;

	$smarty->assign('debug_info', ((defined('DEBUG') && DEBUG) ? generate_debug_info() : ''));

	return true;
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
* Set page headers
*
* @return bool
*/
function set_headers()
{
	if (defined('IS_STYLESHEET') && IS_STYLESHEET)
	{
		header("Content-Type: text/css");
	}
	else
	{
		header('Content-Type: text/html; charset=UTF-8');
	}

	header('Expires: 0');
	header('Pragma: no-cache');

	return true;
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
			if (defined('DEBUG') && DEBUG)
			{
				$msg = sprintf($msg, 'Notice');
			}
			else
			{
				return true;
			}
			break;
		default:
			$msg = sprintf($msg, "[$errno]");
			break;
	}

	error_box($msg, array(), 'PHP Error');
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
	global $root_path, $phpEx, $controller;

	# For now, we only send user error, don't send header status
	/*
	global $_SERVER;

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
	*/

	if (empty($message))
	{
		switch($code)
		{
			case 403:
				$message = 'Forbidden';
				$file_name = 'forbidden';
				break;
			case 404:
				$message = 'Not Found';
				$file_name = 'not_found';
				break;
		}

		if (isset($controller))
		{
			unset($controller);
		}

		if (file_exists($root_path . 'controllers/http_status_' . $file_name . '.' . $phpEx))
		{
			include($root_path . 'controllers/http_status_' . $file_name . '.' . $phpEx);

			$controller_class_name = 'controller_http_status_' . $file_name;

			$controller = new $controller_class_name();
			$controller->index();
		}
	}

	# See some line up this
	# header($http . ' ' . $code . ' ' . $message, true, $code);

	return false;
}

/**
* Output an error message
*
* @param string $msg message of error box
* @param array $params params for error box message
* @param mixed $title optional title for error box
* @return bool
*/
function error_box($msg = '', $params = array(), $title = false)
{
	global $lang, $user, $smarty;

	if ($msg != '')
	{
		@ob_clean();

		if ($msg == strtoupper($msg) && isset($lang[$msg]))
		{
			$_msg = $lang[$msg];
		}
		else
		{
			$_msg = $msg;
		}

		switch($msg)
		{
			case 'ERR_SQL_CONNECT':
			case 'ERR_SQL_SELECT_DB':
			case 'ERR_NO_TEMPLATE':
			case 'ERR_NO_TEMPLATE_FILE':
			case 'ERR_NO_TEMPLATE_INFO':
			case 'ERR_TEMPLATE_IF_PARSING':
				$_msg .= ' [<b>' . $params[0] . '</b>]';
				break;
			case 'ERR_SQL_QUERY':
				$_msg .= '<br /><br /><code>' . htmlspecialchars($params[0], ENT_QUOTES) . '</code><br /><br />' . $lang['ERR_SQL_QUERY_ERR'] . '<br /><code>' . $params[1];
				break;
			default:
				break;
		}

		$user['page_title'] = (($title === false) ? $lang['ERROR'] : (($title == strtoupper($title) && isset($lang[$title])) ? $lang[$title] : $title));

		$smarty->assign('title', $user['page_title']);
		$smarty->assign('template_html', '<em>' . $_msg . '</em>');
		_template('simple', false);

		close(true);
	}

	return false;
}

/**
* Generate debug info, used for templates
*
* @return string generated debug info
*/
function generate_debug_info()
{
	global $db, $starttime, $_REQUEST;

	if (defined('EXPLAIN') && EXPLAIN && (isset($_REQUEST['passkey']) && $_REQUEST['passkey'] == EXPLAIN_MODE_PASSKEY))
	{
		return;
	}

	$mtime = explode(' ', microtime());
	$totaltime = $mtime[0] + $mtime[1] - $starttime;

	if (defined('DISPLAY_RAM') && DISPLAY_RAM)
	{
		if (function_exists('memory_get_usage'))
		{
			if ($memory_usage = memory_get_usage())
			{
				global $base_memory_usage;
				$memory_usage -= $base_memory_usage;
				$memory_usage = formatsize($memory_usage);
				$display_ram = ' | Memory Usage: ' . $memory_usage;
			}
		}
	}

	return sprintf('Time: %.3fs' . (defined('ENABLE_DATABASE') && ENABLE_DATABASE ? ' | ' . $db->sql_queries . ' Queries' : '') . (isset($display_ram) ? $display_ram : ''), $totaltime);
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
* Check if a template path and template info exists
*
* @param string $__template name of template to check
* @return bool
*/
function check_template($__template)
{
	global $root_path, $config, $user, $phpEx, $smarty;

	$_tpl = $root_path . 'templates/' . $__template . '/';
	$_tpl_info = $_tpl . 'tpl.' . $phpEx;

	if (!file_exists($_tpl) || !is_dir($_tpl))
	{
		error_box('ERR_NO_TEMPLATE', array($__template));
	}

	if (!file_exists($_tpl_info) || !is_file($_tpl_info))
	{
		error_box('ERR_NO_TEMPLATE_INFO', array($__template));
	}
	else
	{
		require($_tpl_info);

		$user['template'] = array(
			'name'		=> (isset($style['name']) ? $style['name'] : 'N/D'),
			'author'	=> (isset($style['author']) ? $style['author'] : 'N/D'),
			'version'	=> (isset($style['version']) ? $style['version'] : '0.0.0'),
			'website'	=> (isset($style['website']) ? $style['website'] : '#')
		);
	}

	$smarty->assign(array(
			'tpl_path'		=> $config->sys->site_root . 'templates/' . $__template . '/',
			'tpl_name'		=> $user['template']['name'],
			'tpl_author'	=> $user['template']['author'],
			'tpl_version'	=> $user['template']['version'],
			'tpl_website'	=> $user['template']['website']
	));

	return true;
}

/**
* Set the folder name of the template which you would to use
*
* @param string $template name of template to set
* @return bool
*/
function set_template($template)
{
	global $config;

	$config->sys->template = $template;

	check_template($template);

	return true;
}

/**
* Check if is active specified plugin with controller
* and if yes, execute it, with page specified
*
* @param string $plugin identificator of plugin
* @param string $page page name to execute
* @param array $active_list list of active plugin
* @return bool
*/
function run_plugin($plugin, $page, $active_list)
{
	global $plugin_name, $plugins;

	if (isset($active_list[$plugin]))
	{
		if (method_exists($plugins->$plugin, $page))
		{
			$plugins->$plugin->$page();

			return true;
		}
	}

	return false;
}

/**
* Format a byte size in corrent file size, adding KB, MB or GB to output string
*
* @param int $bytes bytes to convert
* @return string converted file size
*/
function formatsize($bytes)
{
	$size = $bytes / 1024;

	if ($size < 1024)
	{
		$size = number_format($size, 2);
		$size .= ' KB';
	}
	else
	{
		if ($size / 1024 < 1024)
		{
			$size = number_format($size / 1024, 2);
			$size .= ' MB';
		}
		else if ($size / 1024 / 1024 < 1024)
		{
			$size = number_format($size / 1024 / 1024, 2);
			$size .= ' GB';
		}
	}

	return $size;
}

/**
* Format a timestamp in a string format (only date)
*
* @param int $time timestamp to format
* @return string date converted
*/
function formatdate($time)
{
	if (!is_int($time)) return false;

	global $config, $lang;

	$month = date('n', $time);
	$date = date($config->sys->date_format, $time);
	$date = str_replace('|', $lang['MONTH_' . $month], $date);

	return $date;
}

/**
* Formato a timestamp in a string format (only time)
*
* @param int $time timestamp to format
* @return string time converted
*/
function formattime($time)
{
	if (!is_int($time)) return false;

	global $config;

	$date = date($config->sys->time_format, $time);

	return $date;
}

/**
* Required for closing the system at the end of the page
*
* @param bool $close if true exit at the end of function
*/
function close($exit = false)
{
	global $_REQUEST;

	if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
	{
		global $db;
	}

	if (defined('EXPLAIN') && EXPLAIN && (isset($_REQUEST['passkey']) && $_REQUEST['passkey'] == EXPLAIN_MODE_PASSKEY))
	{
		@ob_clean();
		global $lang, $smarty, $starttime, $bokeh_version, $is_bokeh_stable;

		$mtime = explode(' ', microtime());
		$totaltime = $mtime[0] + $mtime[1] - $starttime;

		$tpl = '';

		$latest_version = retrive_latest_version($is_bokeh_stable, false);

		if ($latest_version !== false && version_compare($latest_version, $bokeh_version, '>'))
		{
			$tpl .= '<p>' . $lang['BOKEH_NOT_UPDATED'] . '<b>' . $latest_version . '</b></p>';
		}

		if (!$is_bokeh_stable)
		{
			$tpl .= '<p>' . $lang['BOKEH_NOT_STABLE'] . '</p>';
		}

		$tpl .= '<p><b>' . $lang['EXPLAIN_PAGE_GENERATE'] . ' ' . sprintf('%.3f', $totaltime) . (defined('ENABLE_DATABASE') && ENABLE_DATABASE ? ' ' . $lang['EXPLAIN_SECONDS_WITH'] . ' ' . $db->sql_queries . ' ' . $lang['EXPLAIN_QUERIES'] : '') . '.</b><br />';

		if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
		{
			$tpl .= $lang['EXPLAIN_SPENT_PHP'] . ': <b>' . sprintf('%.3fs', ($totaltime - $db->time_on_sql)) . '</b> | ' . $lang['EXPLAIN_SPENT_SQL'] . ': <b>' . sprintf('%.3fs', $db->time_on_sql) . '</b></p><br />';

			$i = 0;

			foreach($db->sql_reports as $sql)
			{
				$i++;
				$tpl .= '<p><b>QUERY #' . $i . '</b><br /><code>' . htmlspecialchars($sql['query'], ENT_QUOTES) . '</code><br />' . $lang['EXPLAIN_BEFORE'] . ': ' . sprintf('%.3fs', $sql['before']) . ' | ' . $lang['EXPLAIN_AFTER'] . ': ' . sprintf('%.3fs', $sql['after']) . ' | ' . $lang['EXPLAIN_ELAPSED'] . ': ' . sprintf('%.3fs', $sql['elapsed']) . '</p>';
			}
		}
		else
		{
			$tpl .= $lang['EXPLAIN_SPENT_PHP'] . ': <b>' . sprintf('%.3fs', ($totaltime)) . '</b></p><br />';
		}

		$user['page_title'] = "Explain MODE";

		$smarty->assign('title', $user['page_title']);
		$smarty->assign('template_html', $tpl);
		_template('simple', false);
	}

	if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
	{
		$db->sql_close();
	}

	@ob_end_flush();

	if ($exit === true) exit;
}

/**
* Do a request to Bokeh API server
*
* @param string $service
* @param string $mode
* @param array $params
* @return mixed array response of api request (if executed)
*/
function api_request($service, $mode, $params = array(), $return_errors = true)
{
	global $bokeh_version;

	if (empty($service) || empty($mode))
	{
		return false;
	}

	if (!defined('APIKEY') || APIKEY == '')
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_APIKEY_NOT_SET');
		}
	}

	$post_data = array(
		'apikey' => APIKEY,
		'service' => $service,
		'mode' => $mode
	);

	$post_data += $params;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://api.bokehteknology.net/');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, "Bokeh Platform | Host: {$_SERVER['SERVER_NAME']} | Version: {$bokeh_version}");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	$fetch = curl_exec($ch);

	curl_close($ch);

	if (!$fetch)
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_API_SERVER_OFFLINE');
		}
	}

	$response = json_decode($fetch, true);

	if (isset($response['error']) || (isset($response['news_type']) && $response['news_type'] == 0) || (isset($response['s_news_type']) && $response['s_news_type'] == 0))
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_API_REQUEST');
		}
	}

	return $response;
}

/**
* Retrive latest Bokeh Platform version
*
* @param bool $stable specific if we are using stable version or not
* @param bool $return_errors if true, if there are errors echo errors, else return false
* @return string latest version
*/
function retrive_latest_version($stable = true, $return_errors = true)
{
	global $bokeh_apps_unique_id;

	$request = api_request($bokeh_apps_unique_id, ($stable ? 'stable' : 'dev'), array(), $return_errors);

	return $request['version'];
}
