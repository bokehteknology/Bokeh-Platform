<?php
/**
*
* @package BokehPlatform
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/
define('IN_BOKEH', true);
$root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'includes/bootstrap.' . $phpEx);

dispatch_url();

if ($config->sys->url_controller == 'css')
{
	if (file_exists($root_path . 'views/' . $config->sys->url_page . '.css'))
	{
		header("Content-Type: text/css");

		$smarty->display($config->sys->url_page . '.css');

		close(true);
	}
	else
	{
		set_header_status(404);
	}
}
else if (file_exists($root_path . 'controllers/' . $config->sys->url_controller . '.' . $phpEx))
{
	include($root_path . 'controllers/' . $config->sys->url_controller . '.' . $phpEx);
	$controller_class_name = 'controller_' . $config->sys->url_controller;

	if (class_exists($controller_class_name))
	{
		$controller = new $controller_class_name();

		if (method_exists($controller, $config->sys->url_page))
		{
			$controller_method_name = $config->sys->url_page;

			$controller->$controller_method_name();
		}
		else
		{
			set_header_status(404);
		}
	}
	else
	{
		if (!run_plugin($config->sys->url_controller, $config->sys->url_page, $plugin_controllers_list))
		{
			set_header_status(404);
		}
	}
}
else
{
	if (!run_plugin($config->sys->url_controller, $config->sys->url_page, $plugin_controllers_list))
	{
		set_header_status(404);
	}
}
