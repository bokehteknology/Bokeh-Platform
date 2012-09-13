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

# PHP Version check
if (PHP_VERSION < '5.3.0') die("<p>PHP 5.3 is required.</p>");

# Output Buffering
if (!@ob_start()) die("<p>Output Buffering is required.</p>");

# JSON
if (!function_exists('json_decode') || !function_exists('json_encode')) die("<p>JSON is required.</p>");

# Composer
if (!file_exists($root_path . 'vendor/autoload.' . $phpEx)) die("<p>You have not set up composer dependencies. See http://getcomposer.org/.</p>");

# Setting system start time
$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

# Setting default error reporting
error_reporting(E_ALL ^ E_NOTICE);

if (defined('DISPLAY_RAM') && DISPLAY_RAM)
{
	$base_memory_usage = 0;

	if (function_exists('memory_get_usage'))
	{
		$base_memory_usage = memory_get_usage();
	}
}

# Setting some constants
define('STRIP', (get_magic_quotes_gpc()) ? true : false);

# Load dependencies
require($root_path . 'vendor/autoload.' . $phpEx);

# Load classes
require($root_path . 'includes/classes/config.' . $phpEx);
require($root_path . 'includes/classes/controller.' . $phpEx);
require($root_path . 'includes/classes/loader.' . $phpEx);
require($root_path . 'includes/classes/log.' . $phpEx);
require($root_path . 'includes/classes/plugin.' . $phpEx);

# Load configs
$config = new bp_config();

# BP Object
$bp = new stdClass();

# BP Logger
$bp->log = new bp_log('bp_logger');
$bp->log->pushHandler('Stream', array($config->sys->log_file));

# Set default timezone
date_default_timezone_set($config->sys->timezone);

$config->sys->site_root = $config->sys->server_protocol . '://' . $config->sys->server_name . (($config->sys->server_port != 80 && $config->sys->server_port != 443) ? ":{$config->sys->server_port}" : '') . $config->sys->server_path;
$config->sys->page_url = $config->sys->server_protocol . '://' . $config->sys->server_name . (($config->sys->server_port != 80 && $config->sys->server_port != 443) ? ":{$config->sys->server_port}" : '') . $_SERVER['SCRIPT_NAME'];
$config->sys->page_arg = $_SERVER['QUERY_STRING'];
$config->sys->page_info = ((isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '');

# Require system files
require($root_path . 'includes/functions/application_base.' . $phpEx);
require($root_path . 'includes/functions/bt_api.' . $phpEx);
require($root_path . 'includes/functions/error_handler.' . $phpEx);
require($root_path . 'includes/functions/format.' . $phpEx);
require($root_path . 'includes/functions/plugin.' . $phpEx);
require($root_path . 'includes/functions/server.' . $phpEx);
require($root_path . 'includes/functions/smarty.' . $phpEx);

if (!function_exists('error_box'))
{
	require($root_path . 'includes/functions/error_box.' . $phpEx);
}

# Load default language files
foreach(glob($root_path . 'languages/' . $config->sys->default_language . '/*.' . $phpEx) as $lang_file)
{
	require($lang_file);
}

# Require user language
$client_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : $config->sys->default_language;
$client_lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : $client_lang;

if (file_exists($root_path . 'languages/' . $client_lang . '/bp.' . $phpEx))
{
	foreach(glob($root_path . 'languages/' . $client_lang . '/*.' . $phpEx) as $lang_file)
	{
		require_once($lang_file);
	}
}

# Initialize database class
if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
{
	require($root_path . 'includes/database/' . $config->db->type . '.' . $phpEx);

	$database_class_name = 'database_' . $config->db->type;
	$db = new $database_class_name();
}

# Initialize Smarty
$smarty = new Smarty();

# Smarty settings
$smarty->setTemplateDir($root_path . 'views/');
$smarty->setCompileDir($root_path . 'cache/');
$smarty->setCacheDir($root_path . 'cache/');
$smarty->force_compile = false;
$smarty->compile_check = true;

# Check if DEBUG is active
if (defined('DEBUG') && DEBUG)
{
	error_reporting(E_ALL);
}

# Setting Bokeh version
define('BOKEH_VERSION', '1.0.0-b6');
define('BOKEH_STABLE', false);

# Set template default vars
$smarty->assign(array(
	'root_path'			=> $config->sys->site_root,
	'page_url'			=> ($config->sys->page_url . (($config->sys->page_arg == '') ? '' : ('?' . $config->sys->page_arg))),
	'sitename'			=> $config->sys->site_name,
	'site_description'	=> $config->sys->site_description,
	'meta_keywords'		=> $config->sys->meta_keywords,
	'meta_description'	=> $config->sys->meta_description,
));

# Setting error handler
if (defined('ERROR_HANDLER') && ERROR_HANDLER)
{
	set_error_handler('error_handler');

	$smarty->muteExpectedErrors();
}

# Define true if we are in explain mode else false
if (defined('EXPLAIN_MODE') && EXPLAIN_MODE && defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY != '')
{
	define('EXPLAIN', request_var('explain'));
}
else
{
	define('EXPLAIN', false);
}

# Retrive request vars
$request_vars = retrive_requests_vars($_REQUEST);

# Connect to DB
if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
{
	$db->sql_connect($config->db->host, $config->db->port, $config->db->user, $config->db->pass, $config->db->name);
}

# We do not need this any longer, unset for safety purposes
unset($config->db->pass);

# Plugins that work as controllers
$plugin_controllers_list = array();

# Plugins object
$plugins = new stdClass();

# Load plugins
load_plugins();

# General Smarty vars (copyrights, language)
smarty_assign();
