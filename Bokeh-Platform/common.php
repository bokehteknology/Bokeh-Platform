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
if (PHP_VERSION < '5.2.0') die("<p>PHP 5.2.x is required.</p>");

# Output Buffering
if (!@ob_start()) die("<p>Output Buffering is required.</p>");

# JSON
if (!function_exists('json_decode') || !function_exists('json_encode')) die("<p>JSON is required.</p>");

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
define('SMARTY_DIR', $root_path . 'includes/smarty/');
define('STRIP', (get_magic_quotes_gpc()) ? true : false);

# Define $user array
$user = array();

# Load classes
require($root_path . 'includes/classes/config.' . $phpEx);

# Load configs
$config = new config();

# Set default timezone
date_default_timezone_set($config->sys->timezone);

$config->sys->site_root = $config->sys->server_protocol . '://' . $config->sys->server_name . ($config->sys->server_port != 80 ? ":{$config->sys->server_port}" : '') . $config->sys->server_path;
$config->sys->page_url = $config->sys->server_protocol . '://' . $config->sys->server_name . ($config->sys->server_port != 80 ? ":{$config->sys->server_port}" : '') . $_SERVER['SCRIPT_NAME'];
$config->sys->page_arg = $_SERVER['QUERY_STRING'];
$config->sys->page_info = ((isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : '');

# Require system files
require($root_path . 'includes/functions.' . $phpEx);
require($root_path . 'includes/db_tables.' . $phpEx);
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
$smarty->setTemplateDir($root_path . 'templates/');
$smarty->setCompileDir($root_path . 'cache/');
$smarty->setCacheDir($root_path . 'cache/');
$smarty->force_compile = false;
$smarty->compile_check = true;

# Check if DEBUG is active
if (defined('DEBUG') && DEBUG)
{
	error_reporting(E_ALL);
}

# Setting Bokeh API server info
$bokeh_domain = 'www.bokehteknology.net';
$bokeh_api_server = 'api.bokehteknology.net';
$bokeh_apps_unique_id = 'bokeh_platform';

# Setting Bokeh version
$bokeh_version = '1.0.0-b5';
$is_bokeh_stable = false;

# Set template default vars
$smarty->assign(array(
	'root_path'			=> $config->sys->site_root,
	'bokeh_site'		=> $bokeh_domain,
	'bokeh_version'		=> $bokeh_version,
	'page_url'			=> ($config->sys->page_url . (($config->sys->page_arg == '') ? '' : ('?' . $config->sys->page_arg))),
	'sitename'			=> $config->sys->site_name,
	'site_description'	=> $config->sys->site_description,
	'meta_keywords'		=> $config->sys->meta_keywords,
	'meta_description'	=> $config->sys->meta_description,
	'_tpl'				=> $config->sys->template
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

# Set page headers
set_headers();

# Retrive request vars
$request_vars = retrive_requests_vars($_REQUEST);

# Check if template dir exist and set it
check_template($config->sys->template);

# Connect to DB
if (defined('ENABLE_DATABASE') && ENABLE_DATABASE)
{
	$db->sql_connect($config->db->host, $config->db->port, $config->db->user, $config->db->pass, $config->db->name);
}

# We do not need this any longer, unset for safety purposes
unset($config->db->pass);

# Add out of check below else
# we have an error on index.php
$plugin_controllers_list = array();

# Now activate plugins with a include() of $root_path/plugins/(plugin_name)/(plugin_name).(phpEx)
# After including, add a new object $plugin_(plugin_name) for the class plugin_(plugin_name)
if (defined('ENABLE_PLUGINS') && ENABLE_PLUGINS && count($config->sys->plugins))
{
	foreach($config->sys->plugins as $plugin_name)
	{
		if (file_exists($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx))
		{
			include($root_path . 'plugins/' . $plugin_name . '/' . $plugin_name . '.' . $phpEx);
			$plugin_class_name = 'plugin_' . $plugin_name;

			if (class_exists($plugin_class_name))
			{
				$$plugin_class_name = new $plugin_class_name();

				if ($$plugin_class_name->is_controller)
				{
					$plugin_controllers_list[$plugin_name] = $plugin_name;
				}

				# Include lang file, if required
				if ($$plugin_class_name->load_lang)
				{
					if (file_exists($root_path . 'plugins/' . $plugin_name . '/languages/' . $client_lang . '.' . $phpEx))
					{
						include($root_path . 'plugins/' . $plugin_name . '/languages/' . $client_lang . '.' . $phpEx);
					}
					else
					{
						include($root_path . 'plugins/' . $plugin_name . '/languages/en.' . $phpEx);
					}
				}

				# Load CFG if exist
				if (file_exists($root_path . 'configs/plugins/' . $plugin_name . '.cfg'))
				{
					$$plugin_class_name->config = $config->load_plugin_cfg($plugin_name);
				}
			}
		}
	}
}

# General Smarty vars (copyrights, language)
smarty_assign();
