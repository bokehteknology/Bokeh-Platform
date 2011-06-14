<?php
/**
*
* @package Bokeh Platform
* @version $Id$
* @copyright (c) 2011 Bokeh Platform
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
* Array with tables name
*
*/
$tables_name = array(
	'CONFIG'	=> 'config',
	'SEO_URLS'	=> 'seo_urls'
);

/**
* Defines each tables name
*
*/
foreach($tables_name as $key => $val)
{
	define('T_' . $key,	$prefix . $val);
}

/**
* Unset array
*
*/
unset($tables_name);
?>