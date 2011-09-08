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
* Print page header
*
* @param $title string
*/
function page_header($title = false)
{
	global $config, $lang, $smarty;

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
* @param $tpl_file string
* @param $template bool
*/
function _template($tpl_file, $_template = true)
{
	global $config, $smarty;

	output_debug();

	if ($_template)
	{
		$_template = $config['template'];
		$smarty->display($_template . '/' . $tpl_file . '.tpl');
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
*/
function smarty_assign()
{
	global $lang, $smarty;

	$smarty->assign(array(
		'current_year'	=> date('Y', time())
	));

	foreach($lang as $key => $val)
	{
		$smarty->assign('l_' . strtolower($key), $val);
	}

	return true;
}

/**
* Generate debug info
*
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
* @param $var string
* @param $is_true bool
* @param $is_false bool
*/
function request_var($var, $is_true = true, $is_false = false)
{
	global $_REQUEST;
	return (isset($_REQUEST[$var])) ? $is_true : $is_false;
}

/**
* Set page headers
*
*/
function set_headers() {
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

	return;
}

/**
* Handle all error messages
*
* @param $errno int
* @param $errstr string
* @param $errfile string
* @param $errline int
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
				return;
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
* @param $code int
* @param $message string
*/
function set_header_status($code, $message = '')
{
	global $root_path, $phpEx, $controller;

	/*
	*
	* For now, we only send user error, don't send header status

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
* @param $msg string
* @param $params array
* @param $title string
*/
function error_box($msg = '', $params = array(), $title = false)
{
	global $config, $lang, $user, $smarty;

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
*/
function generate_debug_info()
{
	global $config, $db, $starttime;

	if (defined('EXPLAIN') && EXPLAIN)
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

	return sprintf('Time: %.3fs' . (defined('ENABLE_DATABASE') && ENABLE_DATABASE ? ' | ' . $db->sql_queries . ' Queries' : '') . (isset($display_ram) ? $display_ram : '') . ((defined('EXPLAIN_MODE') && EXPLAIN_MODE)  ? (' | <a href="' . $config['page_url'] . '?' . (($config['page_arg'] == '') ? '' : $config['page_arg'] . '&amp;') . 'explain=1' . '">Explain</a>') : ''), $totaltime);
}

/**
* Retrive request vars and add to array
*
* @param $requests array
*/
function retrive_requests_vars($requests)
{
	return $requests;
}

/**
* Check if a template path and template info exists
*
* @param $__template string
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
			'tpl_path'		=> $config['site_root'] . 'templates/' . $__template . '/',
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
* @param $template string
*/
function set_template($template)
{
	global $config;
	$config['template'] = $template;
	check_template($template);
	return true;
}

/**
* Check if is active specified plugin with controller
* and if yes, execute it, with page specified
*
* @param $plugin string
* @param $page string
* @param $active_list array
*/
function run_plugin($plugin, $page, $active_list)
{
	if (isset($active_list[$plugin]))
	{
		$plugin_class_name = 'plugin_' . $plugin;

		global $$plugin_class_name;

		if (method_exists($$plugin_class_name, $page))
		{
			$$plugin_class_name->$page();

			return true;
		}
	}


	return false;
}

/**
* Format a byte size in corrent file size, adding KB, MB or GB to output string
*
* @param $bytes int
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
* @param $time int
*/
function formatdate($time)
{
	if (!is_int($time)) return false;

	global $config, $lang;

	$month = date('n', $time);
	$date = date($config['date_format'], $time);
	$date = str_replace('|', $lang['MONTH_' . $month], $date);

	return $date;
}

/**
* Formato a timestamp in a string format (only time)
*
* @param $time int
*/
function formattime($time)
{
	if (!is_int($time)) return false;

	global $config;

	$date = date($config['time_format'], $time);

	return $date;
}

/**
* Required for closing the system at the end of the page
*
* @param $close bool
*/
function close($exit = false)
{
	if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
	{
		global $db;
	}

	if (defined('EXPLAIN') && EXPLAIN)
	{
		@ob_clean();
		global $lang, $smarty, $starttime, $bokeh_version, $is_bokeh_stable;

		$mtime = explode(' ', microtime());
		$totaltime = $mtime[0] + $mtime[1] - $starttime;

		$tpl = '';

		$latest_version = retrive_latest_version($is_bokeh_stable);

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
* Retrive latest Bokeh Platform version
*
* @param $stable bool
*/
function retrive_latest_version($stable = true)
{
	global $bokeh_apps_domain, $bokeh_apps_unique_id;

	$get = @file_get_contents('http://' . $bokeh_apps_domain . '/data.xml?service=update&mode=' . $bokeh_apps_unique_id . '_' . ($stable ? 'stable' : 'dev'));

	if (!$get)
	{
		return false;
	}

	$get = json_decode($get, true);

	return $get['version'];
}
