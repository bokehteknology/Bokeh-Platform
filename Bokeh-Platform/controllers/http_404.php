<?php
/**
*
* @package controller_http_404
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

class controller_http_404 extends bp_controller
{
	function index()
	{
		error_box('ERROR_404_EXPLAIN', array(), 'ERROR_404_TITLE');

		close(true);
	}
}
