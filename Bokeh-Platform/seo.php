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
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'common.' . $phpEx);

if (defined('ENABLE_SEO') && ENABLE_SEO && isset($request_vars['p']) && !empty($request_vars['p']))
{
	$sql = "SELECT rewrite_url, real_url FROM " . T_SEO_URLS . " WHERE rewrite_url = '" . addslashes($request_vars['p']) . "' LIMIT 0,1";
	$result = $db->sql_query($sql);
	$data = $db->sql_fetch();
	
	if ($db->sql_affectedrows())
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: " . $data['real_url']);
	}
	else
	{
		header("Location: " . $config['server_protocol'] . '://' . $config['server_name'] . ($config['server_port'] != 80 ? ":{$config['server_port']}" : '') . '/');
	}
}

close(false);
?>