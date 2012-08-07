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

/**
* Plugin base class
*/
class plugin
{
	/**
	* Plugins functions
	*/
	public $plugin;

	/**
	* Specific if the plugin is a controller or a standard plugin
	*/
	public $is_controller = true;

	/**
	* Specific if the plugin have a own language files
	*/
	public $load_lang = true;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->plugin = new loader();
	}
}