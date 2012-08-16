<?php
/**
*
* @package controller_default
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

class controller_default extends bp_controller
{
	function index()
	{
		# this is index page
		# this page have two links:
		# > http://www.mysite.com/bokeh/default/
		# > http://www.mysite.com/bokeh/default/index

		$this->controller->view_header('HOME');
		$this->controller->view('home_body');
		$this->controller->view_footer();
	}
}
