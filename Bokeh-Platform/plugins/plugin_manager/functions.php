<?php
/**
* @package PluginManager
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*/

/*
* Delete an entire directory
*/
function _delete_directory($dir, $rmroot = true)
{
	$list = glob($dir . '{,.}*', GLOB_MARK|GLOB_BRACE);
	$list = !$list ? array() : $list;

	if (count($list) > 0)
	{
		foreach($list as $file)
		{
			if ($file == ($dir . '../') || $file == ($dir . './'))
			{
				continue;
			}

			if (is_dir($file))
			{
				_delete_directory($file);
			}
			else
			{
				unlink($file);
			}
		}
	}

	if ($rmroot)
	{
		rmdir($dir);
	}

	return true;
}

/*
* Find a plugin root directory
*/
function _plugin_root($dir, $plugin_id)
{
	$list = glob($dir . '{,.}*', GLOB_MARK|GLOB_BRACE);
	$list = !$list ? array() : $list;

	if (count($list) > 0)
	{
		foreach($list as $file)
		{
			if ($file == ($dir . '../') || $file == ($dir . './'))
			{
				continue;
			}

			if (is_dir($file))
			{
				if (substr(str_replace($dir, '', $file), 0, -1) == $plugin_id && file_exists($file . $plugin_id . '.ini') && file_exists($file . $plugin_id . '.php'))
				{
					return $file;
				}
				else
				{
					$_plugin_root = _plugin_root($file, $plugin_id);

					if ($_plugin_root == null)
					{
						continue;
					}
					else
					{
						return $_plugin_root;
					}
				}
			}
		}
	}
}
