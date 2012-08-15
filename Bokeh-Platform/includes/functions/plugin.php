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
* Load all active plugins
*/
function load_plugins()
{
	global $config, $root_path, $phpEx, $plugin_controllers_list, $plugins, $client_lang;

	# Now activate plugins with a include() of $root_path/plugins/(plugin_name)/(plugin_name).(phpEx)
	# After including, add a new object $plugins->(plugin_name) for the class plugin_(plugin_name)
	if (defined('ENABLE_PLUGINS') && ENABLE_PLUGINS && count($config->sys->plugins))
	{
		foreach($config->sys->plugins as $plugin_name)
		{
			if (file_exists($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx))
			{
				include($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx);
				$plugin_class_name = 'plugin_' . $plugin_name;

				if (class_exists($plugin_class_name))
				{
					$plugins->$plugin_name = new $plugin_class_name();

					$plugins->$plugin_name->_configure();

					if ($plugins->$plugin_name->is_controller)
					{
						$plugin_controllers_list[$plugin_name] = $plugin_name;
					}

					# Include lang file, if required
					if ($plugins->$plugin_name->load_lang)
					{
						if (file_exists($root_path . 'plugins/' . $plugin_name . '/languages/' . $client_lang . '.' . $phpEx))
						{
							include($root_path . 'plugins/' . $plugin_name . '/languages/' . $client_lang . '.' . $phpEx);
						}
						else
						{
							include($root_path . 'plugins/' . $plugin_name . '/languages/en.' . $phpEx);
						}
					}

					# Load plugin configuration if exist
					if (file_exists($root_path . 'configs/plugins/' . $plugin_name . '.ini'))
					{
						$plugins->$plugin_name->config = $config->load_plugin_cfg($plugin_name);
					}
				}
			}
		}
	}
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
