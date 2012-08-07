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
* Loader class
*/
class loader
{
	/**
	* Path to 'views' directory
	* Used only for plugins with controller
	*
	* @var string
	*/
	public $views_base = '';

	/**
	* Get language string
	*
	* @param string $lang_key language string key
	* @return string language string
	*/
	public function language($lang_key)
	{
		global $lang;

		return $lang[$lang_key];
	}

	/**
	* Set a variable for using in a view
	*
	* @param string $name name of var
	* @param string|array $value value of var
	*/
	public function assign($name, $value)
	{
		global $smarty;

		$smarty->assign($name, $value);
	}

	/**
	* Display a view
	*
	* @param string $file file name of view
	*/
	public function view($file)
	{
		global $smarty;

		$smarty->display($this->views_base . $file . '.html');
	}

	/**
	* Display page header
	*
	* @param string $title title of page
	*/
	public function view_header($title)
	{
		global $lang, $smarty;

		if ($title !== false && $title == strtoupper($title) && isset($lang[$title]))
		{
				$this->assign('title', $lang[$title]);
		}
		else if ($title !== false)
		{
				$this->assign('title', $title);
		}

		$smarty->display('header.html');
	}

	/**
	* Display page footer
	*/
	public function view_footer()
	{
		global $smarty;

		output_debug();

		$smarty->display('footer.html');

		close(false);
	}
}
