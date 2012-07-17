<?php
/**
*
* @package controller_http_status_not_found
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

class controller_http_status_not_found
{
	function controller_http_status_not_found()
	{
		# HTTP Status Page: 404 (Not Found)
	}

	function index()
	{
		error_box('ERROR_404_EXPLAIN', array(), 'ERROR_404_TITLE');

		close(true);
	}
}
