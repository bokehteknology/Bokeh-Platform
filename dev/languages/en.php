<?php
/**
*
* en [English]
*
* @package language
* @copyright (c) 2011 Bokeh Platform
* @author Carlo [uid: 2]
* @version 1.0.0-dev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

// UTF-8 (no BOM)
// Some characters
// ’ » “ ” …

$lang = array_merge($lang, array(
	'LANG_PREFIX'			=> 'en',
	'TRANSLATION_INFO'		=> 'English Translation by carlino1994',
	
	// error_box() messages
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
	
	// explain mode messages
	'EXPLAIN_PAGE_GENERATE'		=> 'Page generated in',
	'EXPLAIN_SECONDS_WITH'		=> 'seconds with',
	'EXPLAIN_QUERIES'			=> 'queries',
	'EXPLAIN_SPENT_PHP'			=> 'Time spent on PHP',
	'EXPLAIN_SPENT_SQL'			=> 'Time spent on database',
	'EXPLAIN_BEFORE'			=> 'Before',
	'EXPLAIN_AFTER'				=> 'After',
	'EXPLAIN_ELAPSED'			=> 'Elapsed',
	
	// install messages
	'INSTALL_BOKEH'				=> 'Installation Panel of Bokeh Platform',
	'INSTALL_PAGE'				=> '<p><strong>Bokeh Platform</strong> is the “simple and faster platform”, is ideal for devlop your site/blog.</p><p>You can also count to a community that provides its users several plugins, which will have the ability to increase its functionality.</p><p>Bokeh Platform was created as an Open Source project in December 2009, developed from <a href="http://BOKEH_SITE/"><em>Bokeh Teknology</em></a> website.</p><p>If you want to help in this project, visit us on our site <a href="http://BOKEH_SITE/">BOKEH_SITE</a>.</p>',
	'INSTALL_INSTALL_ERRORS'	=> 'During installation, the following errors have occurred in the database:',
	'INSTALL_OK'				=> 'The installation was completed. You can now delete the file <em>install.php</em>.',
	'INSTALL_MAIN'				=> 'Main',
	'INSTALL_INSTALL'			=> 'Installation',
	'INSTALL_INFORMATIONS'		=> 'Information',
	'INSTALL_TYPE'				=> 'Type',
	'INSTALL_HOST'				=> 'Host',
	'INSTALL_PORT'				=> 'Port',
	'INSTALL_DBNAME'			=> 'Database name',
	'INSTALL_TABLE_PREFIX'		=> 'Table prefix',
	'INSTALL_CONTINUE'			=> '&raquo; Continue',
	'INSTALL_INSTALL'			=> '&raquo; Install',
	'INSTALL_DETAILS'			=> 'Details',
	
	// some default messages
	'USERNAME'	=> 'Username',
	'PASSWORD'	=> 'Password',
	
	// pages title
	'HOME'		=> 'Home',
	
	// server messages
	'SITE_INFO'			=> 'Site information',
	'DATABASE_INFO'		=> 'Database information',
	'SITENAME'			=> 'Site name',
	'SITE_DESCRIPTION'	=> 'Site description',
	'META_DESCRIPTION'	=> 'Description [META]',
	'META_KEYWORDS'		=> 'Keywords [META]',
	'TEMPLATE'			=> 'Template',
	'SETTINGS'			=> 'Settings',
	
	// default blog strings
	'BLOG_SEARCH'		=> 'Search',
	'BLOG_PUBLISHED_ON'	=> 'Published on',
	'BLOG_BY'			=> 'by',
	'BLOG_CONTINUE'		=> 'Continue',
	'BLOG_COMMENTS'		=> 'Comments',
	'BLOG_NO_CATS'		=> 'No categories.',
	
	// months
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
	'MONTH_12'	=> 'December',
	
	// siderbar strings
	'CATEGORIES'		=> 'Categories',
	
	// first article strings
	'ARTICLE_TITLE'		=> 'Welcome on',
	'ARTICLE_CONTENT'	=> '<p>la la la la la</p>',
));
?>