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
if (!defined('IN_BOKEH')) {
	exit;
}

/**
* Database Configuration
*/
$dbtype = 'mysql';
$dbhost = 'localhost';
$dbport = '';
$dbname = 'database_name';
$dbuser = 'user_name';
$dbpass = 'user_password';
$prefix = 'bokeh_';

/**
* System Configuration BASE
* Advanced system configuration is to be set via Admin panel
*/
$config = array(
	'server_protocol'		=> 'http',
	'server_name'			=> 'www.mysite.com',
	'server_port'			=> 80,
	'server_path'			=> '/bokeh',
	'default_controller'	=> 'default',
	'site_name'				=> 'My Bokeh Platform site',
	'site_description'		=> 'This is a Bokeh Platform powered site',
	'meta_keywords'			=> 'bokeh, platform, php',
	'meta_description'		=> 'This is a Bokeh Platform powered site',
	'site_email'			=> 'info@mysite.com',
	'template'				=> 'default',
	'date_format'			=> 'j | Y',
	'hour_format'			=> 'H:i',
	'timezone'				=> 'Europe/Rome',
	'plugins_active'		=> array(),
);

/**
* Setting 'Bokeh Teknology' apikey for some plugins and API services
*/
@define('APIKEY', '');

/**
* Enable debug and displaying RAM used
*/
@define('DEBUG', false);
@define('DISPLAY_RAM', false);

/**
* Enable own error handler
*/
@define('ERROR_HANDLER', true);

/**
* Enable explain mode
*/
@define('EXPLAIN_MODE', false);

/**
* Enable database connection
*/
@define('ENABLE_DATABASE', false);

/**
* Enable plugins
*/
@define('ENABLE_PLUGINS', true);
