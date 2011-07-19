<?php
/**
*
* en [English]
*
* @plugin test
* @package language
* @copyright (c) 2011 Bokeh Platform
* @author Bokeh Teknology
* @version 1.0.0
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_BOKEH')) {
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

# UTF-8 (no BOM)
# Some characters
# ’ » “ ” …

$lang = array_merge($lang, array(
	'PLUGIN_TEST_TITLE'	=> 'Test Plugin',
	'PLUGIN_TEST_BODY'	=> 'This is a testing plugin!'
));
