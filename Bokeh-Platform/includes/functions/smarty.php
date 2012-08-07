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
* <p>
* We do not use it directly
* <p>
* Params:
* <pre>
* - base_url   - (optional) - an URL from Bokeh Platform root
* - c          - (optional) - controller name, default is the default controller
* - p          - (optional) - page name, default is 'index'
* - params     - (optional) - extra params for the page (in GET style)
* </pre>
* Examples:
* <pre>
* {bp_path base_url="public/myfile.zip"} => http://www.mysite.com/bokeh/public/myfile.zip
* {bp_path c="default"} => http://www.mysite.com/bokeh/default
* {bp_path c="default" p="index"} => http://www.mysite.com/bokeh/default/index
* {bp_path c="default" params="id=4"} => http://www.mysite.com/bokeh/default?id=4
* {bp_path c="default" p="index" params="id=4"} => http://www.mysite.com/bokeh/default/index?id=4
* {bp_path c="default" p="index" params="id=4&page=1"} => http://www.mysite.com/bokeh/default/index?id=4&page=1
* {bp_path c="default" p="index" params="id="|cat:$product_id|cat:"&page="|cat:$page} => http://www.mysite.com/bokeh/default/index?id={$product_id}&page={$page}
* </pre>
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
		$params['c'] = isset($params['c']) ? $params['c'] : $config->sys->default_controller;
		$params['p'] = isset($params['p']) ? "/{$params['p']}" : '';
		$params['params'] = isset($params['params']) ? $params['params'] : '';

		return "{$config->sys->site_root}{$params['c']}{$params['p']}{$params['params']}";
	}
}
