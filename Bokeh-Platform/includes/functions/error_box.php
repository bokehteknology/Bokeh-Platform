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
* Output an error message
*
* @param string $msg message of error box
* @param array $params params for error box message
* @param mixed $title optional title for error box
* @return bool
*/
function error_box($msg = '', $params = array(), $title = false)
{
	global $lang, $smarty, $log;

	if ($msg != '')
	{
		@ob_clean();

		output_debug();

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
			case 'ERR_NO_TEMPLATE_FILE':
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
		$smarty->display('simple.html');

		close(true);
	}

	return false;
}
