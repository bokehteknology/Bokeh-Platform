<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/
define('IN_BOKEH', true);
$root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'common.' . $phpEx);

# Set URL data
$url_data = $config['page_info'];

# Clean URL data
$chars_count_old = count_chars($url_data, 1);
$chars_count = array();

foreach($chars_count_old as $chr => $count)
{
	$chars_count[chr($chr)] = $count;
}

$slash = (isset($chars_count['/'])) ? $chars_count['/'] : 0;

$config['url_controller'] = $config['default_controller'];
$config['url_page'] = 'index';

if ($slash == 0 || $slash == 1)
{
	if ($slash == 1)
	{
		$url_data = str_replace('/', '', $url_data);
	}

	if (strlen($url_data) >= 1)
	{
		$config['url_controller'] = $url_data;
	}
}
else if ($slash >= 2)
{
	$url_data = substr($url_data, 1);
	$url_data = explode('/', $url_data);

	if (strlen($url_data[0]) >= 1)
	{
		$config['url_controller'] = $url_data[0];
	}

	if (strlen($url_data[1]) >= 1)
	{
		$config['url_page'] = $url_data[1];
	}
}

if (file_exists($root_path . 'controllers/' . $config['url_controller'] . '.' . $phpEx))
{
	include($root_path . 'controllers/' . $config['url_controller'] . '.' . $phpEx);
	$controller_class_name = 'controller_' . $config['url_controller'];

	if (class_exists($controller_class_name))
	{
		$controller = new $controller_class_name();

		if (method_exists($controller, $config['url_page']))
		{
			$controller_method_name = $config['url_page'];

			$controller->$controller_method_name();
		}
		else
		{
			set_header_status(404);
		}
	}
	else
	{
		if (!run_plugin($config['url_controller'], $config['url_page'], $plugin_controllers_list))
		{
			set_header_status(404);
		}
	}
}
else
{
	if (!run_plugin($config['url_controller'], $config['url_page'], $plugin_controllers_list))
	{
		set_header_status(404);
	}
}
