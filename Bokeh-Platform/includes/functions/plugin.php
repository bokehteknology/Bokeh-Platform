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
* Check if is active specified plugin with controller
* and if yes, execute it, with page specified
*
* @param string $plugin identificator of plugin
* @param string $page page name to execute
* @param array $active_list list of active plugin
* @return bool
*/
function run_plugin($plugin, $page, $active_list)
{
	global $plugin_name, $plugins, $root_path;

	$disallowed_methods = array('__construct', '_configure');

	if (isset($active_list[$plugin]))
	{
		if (method_exists($plugins->$plugin, $page) && !isset($disallowed_methods[$page]))
		{
			$plugins->$plugin->plugin->views_base = $root_path . 'plugins/' . $plugin . '/views/';

			$plugins->$plugin->$page();

			return true;
		}
	}

	return false;
}
