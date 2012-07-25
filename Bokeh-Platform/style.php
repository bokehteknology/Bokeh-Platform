<?php
/**
*
* @package BokehPlatform
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

define('IN_BOKEH', true);
define('IS_STYLESHEET', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'includes/bootstrap.' . $phpEx);

if (isset($request_vars['_tpl']) && !empty($request_vars['_tpl']))
{
	set_template($request_vars['_tpl']);
	_template($request_vars['_tpl'] . '/stylesheet', false);
}
else
{
	_template('stylesheet');
}

close(false);
