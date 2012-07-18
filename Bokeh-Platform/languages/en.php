<?php
/**
*
* en [English]
*
* @package language
* @copyright (c) 2012 Bokeh Teknology
* @author Bokeh Teknology
* @version 1.0.0-b5
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
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

# UTF-8 (no BOM)
# Some characters
# ’ » “ ” …

$lang = array_merge($lang, array(
	'LANG_PREFIX'			=> 'en',
	'TRANSLATION_INFO'		=> 'English Translation by Bokeh Teknology',

	# error_box() messages
	'ERROR'						=> 'Error',
	'ERR_SQL_CONNECT'			=> 'Could not connect to database server.',
	'ERR_SQL_SELECT_DB'			=> 'Can’t select the database.',
	'ERR_SQL_QUERY'				=> 'There was an error executing the query:',
	'ERR_SQL_QUERY_ERR'			=> 'Information on error:',
	'ERR_SQL_NO_QUERY'			=> 'None specified query.',
	'ERR_SQL_FETCH'				=> 'There was an error while fetching the query.',
	'ERR_NO_TEMPLATE'			=> 'The template does not exist.',
	'ERR_NO_TEMPLATE_FILE'		=> 'The template file requested does not exist.',
	'ERR_NO_STYLESHEET_FILE'	=> 'The stylesheet does not exist.',
	'ERR_NO_TEMPLATE_INFO'		=> 'The file containing information on the template does not exist.',
	'ERR_TEMPLATE_IF_PARSING'	=> 'There was an error during parsing the template.',
	'ERR_API_SERVER_OFFLINE'	=> 'The API server for Bokeh Teknology services is unreachable, so is not possible to perform the desired request.',
	'ERR_API_REQUEST'			=> 'There was an error while processing the API request for Bokeh Teknology services.',
	'ERR_APIKEY_NOT_SET'		=> 'The apikey for Bokeh Teknology services has not been configured, so you can not perform the API request.',

	# http errors
	'ERROR_403_TITLE'	=> 'Error 403',
	'ERROR_403_EXPLAIN'	=> 'You don’t have permission to access this page.',
	'ERROR_404_TITLE'	=> 'Error 404',
	'ERROR_404_EXPLAIN'	=> 'There isn’t any page with this name.',

	// explain mode messages
	'EXPLAIN_PAGE_GENERATE'		=> 'Page generated in',
	'EXPLAIN_SECONDS_WITH'		=> 'seconds with',
	'EXPLAIN_QUERIES'			=> 'queries',
	'EXPLAIN_SPENT_PHP'			=> 'Time spent on PHP',
	'EXPLAIN_SPENT_SQL'			=> 'Time spent on database',
	'EXPLAIN_BEFORE'			=> 'Before',
	'EXPLAIN_AFTER'				=> 'After',
	'EXPLAIN_ELAPSED'			=> 'Elapsed',

	# some default messages
	'USERNAME'	=> 'Username',
	'PASSWORD'	=> 'Password',

	# pages title
	'HOME'		=> 'Home',

	# server messages
	'SITE_INFO'			=> 'Site information',
	'DATABASE_INFO'		=> 'Database information',
	'SITENAME'			=> 'Site name',
	'SITE_DESCRIPTION'	=> 'Site description',
	'META_DESCRIPTION'	=> 'Description [META]',
	'META_KEYWORDS'		=> 'Keywords [META]',
	'TEMPLATE'			=> 'Template',
	'SETTINGS'			=> 'Settings',

	# version check
	'BOKEH_NOT_UPDATED'	=> 'Bokeh Platform isn’ updated! The latest version available is: ',
	'BOKEH_NOT_STABLE'	=> 'Please note that you are not using the <b>stable</b> version of Platform Bokeh!',

	# months
	'MONTH_1'	=> 'January',
	'MONTH_2'	=> 'February',
	'MONTH_3'	=> 'March',
	'MONTH_4'	=> 'April',
	'MONTH_5'	=> 'May',
	'MONTH_6'	=> 'June',
	'MONTH_7'	=> 'July',
	'MONTH_8'	=> 'August',
	'MONTH_9'	=> 'September',
	'MONTH_10'	=> 'October',
	'MONTH_11'	=> 'November',
	'MONTH_12'	=> 'December'
));
