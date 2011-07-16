<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_BOKEH', true);
define('IS_STYLESHEET', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'common.' . $phpEx);

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
