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
		global $lang, $smarty, $starttime;

		$mtime = explode(' ', microtime());
		$totaltime = $mtime[0] + $mtime[1] - $starttime;

		$tpl = '';

		$latest_version = retrive_latest_version(BOKEH_STABLE, false);

		if ($latest_version !== false && version_compare($latest_version, BOKEH_VERSION, '>'))
		{
			$tpl .= '<p>' . $lang['BOKEH_NOT_UPDATED'] . '<b>' . $latest_version . '</b></p>';
		}

		if (!BOKEH_STABLE)
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

		$smarty->assign('title', 'Explain MODE');
		$smarty->assign('template_html', $tpl);
		$smarty->display('simple.html');
	}

	if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
	{
		$db->sql_close();
	}

	@ob_end_flush();

	if ($exit === true) exit;
}
