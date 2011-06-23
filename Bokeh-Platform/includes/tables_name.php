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

# Array with tables name
$tables_name = array(
	'EXAMPLE'	=> 'example' # T_EXAMPLE constant point to prefix_example
);

# Do not add table constants
# if database is not enabled
if (!defined('ENABLE_DATABASE') || !ENABLE_DATABASE)
{
	# Defines each table name
	foreach($tables_name as $key => $val)
	{
		define('T_' . $key,	$prefix . $val);
	}
}

# Unset array
unset($tables_name);
?>