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

class controller_default
{
	function controller_default()
	{
		# here you can put some code for init your controller
	}

	function index()
	{
		# this is index page
		# this page have two links:
		# > http://www.mysite.com/bokeh/index.php/default/
		# > http://www.mysite.com/bokeh/index.php/default/index

		page_header('HOME');
		_template('home_body');
		page_footer();
	}
}
