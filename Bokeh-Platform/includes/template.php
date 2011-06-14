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

/**
* Template system class
*
*/
class template
{
	var $tpl_var = array();
	var $templates = array();
	
	/**
	* Initialize template system
	*
	*/
	function template()
	{
		global $user;
		
		# General template vars
		$this->add_vars(array(
			'CURRENT_YEAR'	=> date('Y', time())
		));
		
		# Add lang vars to template
		foreach($user['lang'] as $key => $val)
		{
			$this->add_vars(array(
				'L_' . $key	=> $val
			));
		}
	}
	
	/**
	* Generate a simple template
	*
	*/
	function simple_template()
	{
		global $user;
		
		$tpl = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
		$tpl .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"ltr\" lang=\"it\" xml:lang=\"it\">\n";
		$tpl .= "	<head>\n";
		$tpl .= "		<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />\n";
		$tpl .= "		<meta http-equiv=\"content-style-type\" content=\"text/css\" />\n";
		$tpl .= "		<meta http-equiv=\"content-language\" content=\"{L_LANG_PREFIX}\" />\n";
		$tpl .= "		<meta http-equiv=\"imagetoolbar\" content=\"no\" />\n";
		$tpl .= "		<meta name=\"resource-type\" content=\"document\" />\n";
		$tpl .= "		<meta name=\"distribution\" content=\"global\" />\n";
		$tpl .= "		<meta name=\"copyright\" content=\"{CURRENT_YEAR}, Bokeh Teknology. Tutti i diritti riservati.\" />\n";
		$tpl .= "		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />\n";
		$tpl .= "		\n";
		$tpl .= "		<title>Bokeh Platform - {TITLE}</title>\n";
		$tpl .= "		\n";
		$tpl .= "		<style type=\"text/css\">\n";
		$tpl .= "		<!--\n";
		$tpl .= "		body         { font-family: Verdana; color: #000000; font-size:8pt; background-color:#ffffff }\n";
		$tpl .= "		a:active     { font-weight:bold; color:#000000 }\n";
		$tpl .= "		a:link       { font-weight:bold; color:#000000 }\n";
		$tpl .= "		a:visited    { font-weight:bold; color:#000000 }\n";
		$tpl .= "		table        { padding-top:1; padding-bottom:1; padding-left:2; padding-right:2 }\n";
		$tpl .= "		tr           { }\n";
		$tpl .= "		td           { font-family:Verdana; font-size:8pt }\n";
		$tpl .= "		th           { font-family:Verdana; font-size:12pt; font-weight:bold; color:#808080; text-align:left; margin-left:8; margin-bottom:4 }\n";
		$tpl .= "		h1           { padding:0; font-size:16pt;  }\n";
		$tpl .= "		h2           { border-style:outset; border-width:1; font-size:14pt }\n";
		$tpl .= "		h3           { font-size:12pt; border-left-width:1; border-right-width:1; border-top-width:1; border-bottom-style:solid; border-bottom-width:1 }\n";
		$tpl .= "		html		 { font-size:8pt }\n";
		$tpl .= "		.BorderOn	 { width:90px; margin-left:0px; color:#000000; background-color:#B0B0B0; font-size:8pt; font-family:Verdana }\n";
		$tpl .= "		.BorderOff	 { width:90px; margin-left:0px; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }\n";
		$tpl .= "		.title		 { position: relative; width: 100px; height: 10px; z-index: 10; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }\n";
		$tpl .= "		.submenu	 { padding:0; position: relative; left: 10px; width: 90px; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }\n";
		$tpl .= "		.gradient01  { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#4B92D9', endColorStr='#CEDFF6', gradientType='1') }\n";
		$tpl .= "		.gradient02	 { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#CEDFF6', endColorStr='#1E77D3', gradientType='1') }\n";
		$tpl .= "		.gradient03	 { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#0A6CCE', endColorStr='#FFFFFF', gradientType='1') }\n";
		$tpl .= "		.gradient04  { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#CCCCCC', endColorStr='#EEEEEE', gradientType='1') }\n";
		$tpl .= "		.bodygray    { font-family: Verdana; color: #000000; font-size:8pt; background-color:#dddddd }\n";
		$tpl .= "		.bodylgray   { font-family: Verdana; color: #000000; font-size:8pt; background-color:#eeeeee }\n";
		$tpl .= "		// -->\n";
		$tpl .= "		</style>\n";
		$tpl .= "	</head>\n";
		$tpl .= "	<body>\n";
		$tpl .= "		<h1>Bokeh Platform</h1>\n";
		$tpl .= "		<h3>{TITLE}</h3>\n";
		$tpl .= "		<p>{TEMPLATE}</p>\n";
		$tpl .= "		\n";
		$tpl .= "		<p style=\"text-align: right\"><em>\n";
		$tpl .= "		Powered by <a href=\"http://{BOKEH_SITE}/\">Bokeh Teknology</a>, 2009, {CURRENT_YEAR}<br />\n";
		$tpl .= "		{L_TRANSLATION_INFO}<br />\n";
		$tpl .= "		{DEBUG_INFO}\n";
		$tpl .= "		</em></p>\n";
		$tpl .= "	</body>\n";
		$tpl .= "</html>";
		
		$this->add_vars(array('TITLE' => $user['page_title']));		
		$this->templates['simple_template'] = $tpl;
		return $tpl;
	}
	
	/**
	* Add vars to templates
	*
	* @param $var array
	*/
	function add_vars($var)
	{
		if (!is_array($var)) return false;
		
		foreach($var as $key => $val)
		{
			$this->tpl_var['{' . $key . '}'] = $val;
		}
		
		return true;
	}
	
	/**
	* Return or echo compiled template
	*
	* @param $tpl string
	* @param $echo bool
	*/
	function _template($tpl = '', $echo = true)
	{
		global $root_path;
		$this->output_debug();
		if ($tpl == '' || !isset($this->templates[$tpl])) $this->load_template($tpl);
		$new_tpl = str_replace(array_keys($this->tpl_var), array_values($this->tpl_var), $this->templates[$tpl]);
		
		# Internal URL System with relative path (from $root_path)
		$new_tpl = preg_replace("#\{U_(.*?)\}#", "{$root_path}$1", $new_tpl);
		
		if ($echo === true) echo $new_tpl; else return $new_tpl;
	}
	
	/**
	* Load a template into Bokeh Platform
	*
	* @param $tpl string
	*/
	function load_template($tpl)
	{
		global $root_path, $config;
		
		$_tpl = $root_path . 'template/' . $config['template'] . '/' . $tpl . '.tpl';
		
		if (file_exists($_tpl) && is_file($_tpl) && filesize($_tpl) > 0)
		{
			$handle = fopen($_tpl, 'r');
			$this->templates[$tpl] = @fread($handle, filesize($_tpl));
			fclose($handle);
		}
		else
		{
			switch($tpl)
			{
				case 'stylesheet':
					error_box('ERR_NO_STYLESHEET_FILE');
					break;
				default:
					error_box('ERR_NO_TEMPLATE_FILE', array($tpl . '.tpl'));
					break;
			}
		}
	}
	
	/**
	* Generate page header
	*
	* @param $title string
	*/
	function page_header($title = false)
	{
		if ($title !== false) $this->add_vars(array('TITLE' => $title));
		$this->_template('header');
		return;
	}
	
	/**
	* Generate page footer
	*
	*/
	function page_footer()
	{
		$this->output_debug();
		$this->_template('footer');
		close(false);
		return;
	}
	
	/**
	* Add debug info to template if debug mode enabled
	*
	*/
	function output_debug()
	{
		$this->add_vars(array(
			'DEBUG_INFO'	=> (defined('DEBUG') && DEBUG) ? generate_debug_info() : ''
		));
	}
}
?>