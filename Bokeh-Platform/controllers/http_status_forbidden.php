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

class controller_http_status_forbidden
{
	function controller_http_status_forbidden()
	{
		# HTTP Status Page: 403 (Forbidden)
	}

	function index()
	{
		error_box('ERROR_403_EXPLAIN', array(), 'ERROR_403_TITLE');

		close(true);
	}
}
?>