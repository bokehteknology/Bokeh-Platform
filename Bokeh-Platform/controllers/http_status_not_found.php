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

class controller_http_status_not_found
{
	function controller_http_status_not_found()
	{
		# HTTP Status Page: 404 (Not Found)
	}

	function index()
	{
		global $lang;

		error_box($lang['ERROR_404_EXPLAIN'], array(), $lang['ERROR_404_TITLE']);
	}
}
?>