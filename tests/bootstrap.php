<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/
define('IN_BOKEH', true);
$root_path = 'Bokeh-Platform/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

# Output Buffering
if (!@ob_start()) die("<p>Output Buffering is required.</p>");

# JSON
if (!function_exists('json_decode') || !function_exists('json_encode')) die("<p>JSON is required.</p>");

# Setting some constants
define('SMARTY_DIR', $root_path . 'includes/smarty/');
define('STRIP', (get_magic_quotes_gpc()) ? true : false);

# Load classes
require($root_path . 'includes/classes/config.' . $phpEx);
require($root_path . 'includes/classes/controller.' . $phpEx);
require($root_path . 'includes/classes/loader.' . $phpEx);
require($root_path . 'includes/classes/plugin.' . $phpEx);

# Require system files
require($root_path . 'includes/smarty/Smarty.class.' . $phpEx);
require($root_path . 'includes/functions/application_base.' . $phpEx);
require($root_path . 'includes/functions/bt_api.' . $phpEx);
require($root_path . 'includes/functions/error_handler.' . $phpEx);
require($root_path . 'includes/functions/format.' . $phpEx);
require($root_path . 'includes/functions/plugin.' . $phpEx);
require($root_path . 'includes/functions/server.' . $phpEx);
require($root_path . 'includes/functions/smarty.' . $phpEx);

# Load databases classes
require($root_path . 'includes/database/mysql.' . $phpEx);
require($root_path . 'includes/database/mysqli.' . $phpEx);

# Custom error_box() for PHPUnit tests
function error_box($msg = '', $params = array(), $title = false)
{
	return false;
}
