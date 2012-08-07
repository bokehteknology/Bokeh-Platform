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
* Assign to Smarty general vars
*
* @return bool
*/
function smarty_assign()
{
	global $lang, $smarty;

	$smarty->assign(array(
		'current_year'	=> date('Y', time())
	));

	$_lang = array();

	foreach($lang as $key => $val)
	{
		$_lang[strtolower($key)] = $val;
	}

	$smarty->assign('lang', $_lang);

	return true;
}

/**
* Custom smarty function for
* generate URL based on BP path
*
* We do not use it directly
*/
function smarty_function_bp_path($params, $template)
{
	global $config;

	if (isset($params['base_url']))
	{
		return "{$config->sys->site_root}{$params['base_url']}";
	}
	else
	{
		$params['p'] = isset($params['p']) ? "/{$params['p']}" : '';
		$params['params'] = isset($params['params']) ? "{$params['params']}" : '';

		return "{$config->sys->site_root}{$params['c']}{$params['p']}{$params['params']}";
	}
}
