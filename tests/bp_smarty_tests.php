<?php
/**
*
* @package bp_tests
* @copyright (c) 2012 Bokeh Teknology
* @license http://opensource.org/licenses/gpl-3.0.html GNU GPL v3
*
*/

class bp_smarty_tests extends PHPUnit_Framework_TestCase
{
	# Load Smarty
	public function test_load()
	{
		global $root_path;

		$smarty = new Smarty();

		$smarty->setTemplateDir($root_path . 'views/');
		$smarty->setCompileDir($root_path . 'cache/');
		$smarty->setCacheDir($root_path . 'cache/');
		$smarty->force_compile = false;
		$smarty->compile_check = true;

		$this->assertEquals($root_path . 'views/', $smarty->getTemplateDir('0'));
		$this->assertEquals($root_path . 'cache/', $smarty->getCompileDir());
		$this->assertEquals($root_path . 'views/', $smarty->getCacheDir());
		$this->assertFalse($smarty->force_compile);
		$this->assertTrue($smarty->compile_check);
	}
}
