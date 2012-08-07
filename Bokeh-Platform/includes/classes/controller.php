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
* Controller base class
*/
class controller
{
	/**
	* Controllers functions
	*
	* @var loader
	*/
	public $controller;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->controller = new loader();
	}
}
