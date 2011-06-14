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
define('BOKEH_INSTALL', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($root_path . 'common.' . $phpEx);

$mode = isset($request_vars['mode']) ? $request_vars['mode'] : 'main';

$smarty->assign(array(
	'mode'			=> $mode,
	'dbtype'		=> isset($__database_name__)  ? $__database_name__ : 'N/D',
	'dbhost'		=> $dbhost,
	'dbport'		=> empty($dbport) ? 'default' : $dbport,
	'dbname'		=> $dbname,
	'dbuser'		=> $dbuser,
	'table_prefix'	=> $prefix,
	
	's_apikey'			=> defined('APIKEY') ? APIKEY : '',
	's_debug'			=> (defined('DEBUG') && DEBUG) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>',
	's_display_ram'		=> (defined('DISPLAY_RAM') && DISPLAY_RAM) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>',
	's_error_handler'	=> (defined('ERROR_HANDLER') && ERROR_HANDLER) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>',
	's_explain_mode'	=> (defined('EXPLAIN_MODE') && EXPLAIN_MODE) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>',
	's_enable_plugins'	=> (defined('ENABLE_PLUGINS') && ENABLE_PLUGINS) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>',
	's_enable_seo'		=> (defined('ENABLE_SEO') && ENABLE_SEO) ? '<font color="#317C19">true</font>' : '<font color="#7C1921">false</font>'
));

switch($mode)
{
	case 'details':
		$__template__ = 'details_body';
		break;
	case 'install':
		$schema_data = array(
			'mysql'		=> array(
				"CREATE TABLE " . T_CONFIG . " (config_name TEXT NOT NULL, config_value TEXT NOT NULL) CHARACTER SET `utf8` COLLATE `utf8_bin`;",
				"CREATE TABLE " . T_SEO_URLS . " (url_id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY, rewrite_url TEXT NOT NULL, real_url TEXT NOT NULL) CHARACTER SET `utf8` COLLATE `utf8_bin`;",
				"INSERT INTO " . T_CONFIG . " (config_name, config_value) VALUES 
					('site_name', 'My Bokeh Platform site'), 
					('site_description', 'This is a Bokeh Platform powered site'), 
					('meta_keywords', 'bokeh, platform, php'), 
					('meta_dscription', 'This is a Bokeh Platform powered site'), 
					('site_email', 'info@mysite.com'), 
					('template', 'default'), 
					('date_format', 'j | Y'), 
					('hour_format', 'H:i'),
					('plugins_active', '[]');"
			)
		);
		
		$errors = array();
		
		foreach($schema_data[$dbtype] as $sql)
		{
			$result = $db->sql_query($sql);
			
			if (!$result)
			{
				$errors[] = $sql;
			}
		}
		
		if (count($errors) > 0)
		{
			$smarty->assign('install_errors', 'yes');
			$smarty->assign('install_errors_list', implode('<br />', $errors));
		}
		else
		{
			$smarty->assign('install_errors', 'no');
		}
		
		$__template__ = 'install_body';
		break;
	default:
		$smarty->assign(array('install_page' => str_replace('BOKEH_SITE', $bokeh_domain, $user['lang']['INSTALL_PAGE'])));
		$__template__ = 'body';
		break;
}

set_template('install');
page_header();
_template($__template__);
page_footer();
?>