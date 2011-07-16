<?php
/**
*
* it [Italian]
*
* @plugin test
* @package language
* @copyright (c) 2011 Bokeh Platform
* @author Carlo [uid: 2]
* @version 1.0.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

// UTF-8 (no BOM)
// Some characters
// ’ » “ ” …

$lang = array_merge($lang, array(
	'PLUGIN_TEST_TITLE'	=> 'Test Plugin',
	'PLUGIN_TEST_BODY'	=> 'Questo è un plugin di prova!'
));
