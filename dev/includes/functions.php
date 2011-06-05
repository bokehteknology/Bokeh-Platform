<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	global $config, $smarty;
	
	if ($title !== false) $smarty->assign('title', $title);
	
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
	global $user, $smarty;
	
	$smarty->assign(array(
		'current_year'	=> date('Y', time())
	));
	
	foreach($user['lang'] as $key => $val)
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
* Output an error message
*
* @param $msg string
* @param $params array
* @param $title string
*/
function error_box($msg = '', $params = array(), $title = false)
{
	global $config, $user, $smarty;
	
	if ($msg != '')
	{
		@ob_clean();

		if ($msg == strtoupper($msg) && isset($user['lang'][$msg]))
		{
			$_msg = $user['lang'][$msg];
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
				$_msg .= '<br /><br /><code>' . htmlspecialchars($params[0], ENT_QUOTES) . '</code><br /><br />' . $user['lang']['ERR_SQL_QUERY_ERR'] . '<br /><code>' . $params[1];
				break;
			default:
				break;
		}
		
		$user['page_title'] = (($title === false) ? $user['lang']['ERROR'] : $title);
		
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
	
	return sprintf('Time: %.3fs | ' . $db->sql_queries . ' Queries' . (isset($display_ram) ? $display_ram : '') . ((defined('EXPLAIN_MODE') && EXPLAIN_MODE)  ? (' | <a href="' . $config['page_url'] . '?' . $config['page_arg'] . '&amp;explain=1' . '">Explain</a>') : ''), $totaltime);
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
	global $root_path, $user, $phpEx, $smarty;
		
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
			'tpl_path'		=> $_tpl,
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
	
	global $config, $user;
	
	$month = date('n', $time);
	$date = date($config['date_format'], $time);
	$date = str_replace('|', $user['lang']['MONTH_' . $month], $date);
	
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
	global $db;
	
	if (defined('EXPLAIN') && EXPLAIN)
	{
		@ob_clean();
		global $user, $smarty, $starttime;
		
		$mtime = explode(' ', microtime());
		$totaltime = $mtime[0] + $mtime[1] - $starttime;
		
		$tpl = '<p><b>' . $user['lang']['EXPLAIN_PAGE_GENERATE'] . ' ' . sprintf('%.3f', $totaltime) . ' ' . $user['lang']['EXPLAIN_SECONDS_WITH'] . ' ' . $db->sql_queries . ' ' . $user['lang']['EXPLAIN_QUERIES'] . '.</b><br />';
		$tpl .= $user['lang']['EXPLAIN_SPENT_PHP'] . ': <b>' . sprintf('%.3fs', ($totaltime - $db->time_on_sql)) . '</b> | ' . $user['lang']['EXPLAIN_SPENT_SQL'] . ': <b>' . sprintf('%.3fs', $db->time_on_sql) . '</b></p><br />';
		
		$i = 0;
		
		foreach($db->sql_reports as $sql)
		{
			$i++;
			$tpl .= '<p><b>QUERY #' . $i . '</b><br /><code>' . htmlspecialchars($sql['query'], ENT_QUOTES) . '</code><br />' . $user['lang']['EXPLAIN_BEFORE'] . ': ' . sprintf('%.3fs', $sql['before']) . ' | ' . $user['lang']['EXPLAIN_AFTER'] . ': ' . sprintf('%.3fs', $sql['after']) . ' | ' . $user['lang']['EXPLAIN_ELAPSED'] . ': ' . sprintf('%.3fs', $sql['elapsed']) . '</p>';
		}
		
		$user['page_title'] = "Explain MODE";
		
		$smarty->assign('title', $user['page_title']);
		$smarty->assign('template_html', $tpl);
		_template('simple', false);
	}
	
	$db->sql_close();
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
	if ($stable)
	{
		$file = "https://github.com/carlino1994/Bokeh-Platform/raw/master/bokeh_api/v_stable.txt";
	}
	else
	{
		$file = "https://github.com/carlino1994/Bokeh-Platform/raw/master/bokeh_api/v_dev.txt";
	}
	
	$get = @file_get_contents($file);
	
	if (!$get)
	{
		return false;
	}
	
	return $get;
}

/**
* Generate $config data, getting data from database
*
*/
function generate_config_data()
{
	global $config, $db;
	
	$sql = "SELECT config_name, config_value FROM " . T_CONFIG;
	$db->sql_query($sql);
	
	while($data = $db->sql_fetch())
	{
		$config[$data['config_name']] = $data['config_value'];
	}
	
	return true;
}
?>