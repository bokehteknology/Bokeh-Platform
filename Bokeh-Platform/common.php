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

# PHP Version check
if (PHP_VERSION < '5.2.0') die("<p>PHP 5.2.x is required.</p>");

# Output Buffering
if (!@ob_start()) die("<p>Output Buffering is required.</p>");

# JSON
if (!function_exists('json_decode') || !function_exists('json_encode')) die("<p>JSON is required.</p>");

# Setting system start time
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

if (defined('DISPLAY_RAM') && DISPLAY_RAM)
{
	$base_memory_usage = 0;
	
	if (function_exists('memory_get_usage'))
	{
		$base_memory_usage = memory_get_usage();
	}
}

# Setting some constants
define('SMARTY_DIR', $root_path . 'includes/smarty/');
define('STRIP', (get_magic_quotes_gpc()) ? true : false);

# Start session
session_start();

# Setting some arrays
$config = $user = array();

# Check config file
if (!file_exists($root_path . 'config.' . $phpEx))
{
	die("<p>The config.$phpEx file could not be found.</p>");
}

require($root_path . 'config.' . $phpEx);

date_default_timezone_set($config['timezone']);

$config['page_url'] = $config['server_protocol'] . '://' . $config['server_name'] . ($config['server_port'] != 80 ? ":{$config['server_port']}" : '') . $_SERVER['SCRIPT_NAME'];
$config['page_arg'] = $_SERVER['QUERY_STRING'];

# Set some default $config vars if they are not set in database
$config['site_name'] = 'My Bokeh Platform site';
$config['site_description'] = 'This is a Bokeh Platform powered site';
$config['meta_keywords'] = 'bokeh, platform, php';
$config['meta_description'] = 'This is a Bokeh Platform powered site';
$config['template'] = 'default';
$config['date_format'] = 'j | Y';
$config['hour_format'] = 'H:i';

# Setting default timezone
ini_set('date.timezone', $config['timezone']);

# Require system files
require($root_path . 'includes/functions.' . $phpEx);
require($root_path . 'includes/' . $dbtype . '_db.' . $phpEx);
require($root_path . 'includes/tables_name.' . $phpEx);
require($root_path . 'includes/smarty/Smarty.class.' . $phpEx);

# Require user language
$client_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
$client_lang = isset($_GET['lang']) ? $_GET['lang'] : $client_lang;

if (file_exists($root_path . 'languages/' . $client_lang . '.' . $phpEx))
{
	require($root_path . 'languages/' . $client_lang . '.' . $phpEx);
}
else
{
	require($root_path . 'languages/en.' . $phpEx);
}

$user = array('lang' => $lang);

# Initialize some basic classes
$db = new $__database_class__();
$smarty = new Smarty();

# Smarty settings
$smarty->template_dir = $root_path . 'templates/';
$smarty->compile_dir = $root_path . 'cache/';
$smarty->force_compile = false;
$smarty->compile_check = true;

# General Smarty vars
smarty_assign();

# Check if DEBUG is active
if (defined('DEBUG') && DEBUG)
{
	error_reporting(E_ALL);
	$smarty->deprecation_notices = E_ALL;
}
else
{
	# Report all errors, except notice
	error_reporting(E_ALL ^ E_NOTICE);
	$smarty->deprecation_notices = E_ALL ^ E_NOTICE;
}

# Setting Bokeh domain
$bokeh_domain = 'www.bokehteknology.net';
$bokeh_api_domain = 'apps.bokehteknology.net';
$bokeh_api_path = '/Bokeh-Platform/';

# Setting Bokeh version
$bokeh_version = '1.0.0-dev';

# Set template default vars
$smarty->assign(array(
	'root_path'			=> $root_path,
	'bokeh_site'		=> $bokeh_domain,
	'bokeh_version'		=> $bokeh_version,
	'page_url'			=> ($config['page_url'] . (($config['page_arg'] == '') ? '' : ('?' . $config['page_arg']))),
	'sitename'			=> $config['site_name'],
	'site_description'	=> $config['site_description'],
	'meta_keywords'		=> $config['meta_keywords'],
	'meta_description'	=> $config['meta_description'],
	'_tpl'				=> $config['template']
));

# Setting error handler
if (defined('ERROR_HANDLER') && ERROR_HANDLER) set_error_handler('error_handler');

# Define true if we are in explain mode else false
if (defined('EXPLAIN_MODE') && EXPLAIN_MODE) define('EXPLAIN', request_var('explain')); else define('EXPLAIN', false);

# Set page headers
set_headers();

# Retrive request vars
$request_vars = retrive_requests_vars($_REQUEST);

# Connect to DB
$db->sql_connect($dbhost, $dbport, $dbuser, $dbpass, $dbname);

# We do not need this any longer, unset for safety purposes
unset($dbpass);

# Check if install.php exist, else if is not in install.php page, redirect to error_box()
if (file_exists($root_path . 'install.php'))
{
	if (!defined('BOKEH_INSTALL') && !defined('BOKEH_UPDATE') && !defined('IS_STYLESHEET'))
	{
		error_box("The file install.php exist. If you have installed Bokeh, please delete it, else go to install.php page.");
	}
}

# Check if update.php exist, else if is not in update.php page, redirect to error_box()
if (file_exists($root_path . 'update.php'))
{
	if (!defined('BOKEH_INSTALL') && !defined('BOKEH_UPDATE') && !defined('IS_STYLESHEET'))
	{
		error_box("The file update.php exist. If you have updated Bokeh, please delete it, else go to update.php page.");
	}
}

# Execute some code only if Bokeh Platform is installed, and we are not in install.php page
if (!defined('BOKEH_INSTALL') && !defined('BOKEH_UPDATE') && !defined('IS_STYLESHEET'))
{
	# Get $config array from database, only if we are not in install.php page
	generate_config_data();
	
	# Decode some JSON config data
	$tmp_config_json_decode = array('plugins_active');
	
	foreach($tmp_config_json_decode as $config_key)
	{
		$config[$config_key] = json_decode($config[$config_key]);
	}
	
	unset($tmp_config_json_decode);
	
	# Check if template dir exist and set it
	check_template($config['template']);
	
	# Now activate plugins with a include() of $root_path/plugins/(plugin_name)/(plugin_name).php
	# After including, add a new object $plugin_(plugin_name) for the class plugin_(plugin_name)
	if (defined('ENABLE_PLUGINS') && ENABLE_PLUGINS)
	{
		if (isset($config['plugins_active']) && count($config['plugins_active']))
		{
			foreach($config['plugins_active'] as $plugin_name)
			{
				if (file_exists($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx))
				{
					include($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx);
					$plugin_class_name = 'plugin_' . $plugin_name;
					
					if (class_exists($plugin_class_name))
					{
						$plugin_class_name = new $plugin_class_name();
					}
				}
			}
		}
	}
}

# Now unset some vars, for security purposes
unset($_SERVER, $_REQUEST, $_GET, $_POST);
?>
