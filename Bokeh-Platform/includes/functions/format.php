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
* Format a byte size in corrent file size, adding KB, MB or GB to output string
*
* @param int $bytes bytes to convert
* @return string converted file size
*/
function formatsize($bytes)
{
	$size = $bytes / 1024;

	if ($size < 1024)
	{
		$size = number_format($size, 2);
		$size .= ' KB';
	}
	else
	{
		if ($size / 1024 < 1024)
		{
			$size = number_format($size / 1024, 2);
			$size .= ' MB';
		}
		else if ($size / 1024 / 1024 < 1024)
		{
			$size = number_format($size / 1024 / 1024, 2);
			$size .= ' GB';
		}
	}

	return $size;
}

/**
* Format a timestamp in a string format (only date)
*
* @param int $time timestamp to format
* @return string date converted
*/
function formatdate($time)
{
	if (!is_int($time)) return false;

	global $config, $lang;

	$month = date('n', $time);
	$date = date($config->sys->date_format, $time);
	$date = str_replace('|', $lang['MONTH_' . $month], $date);

	return $date;
}

/**
* Format a timestamp in a string format (only time)
*
* @param int $time timestamp to format
* @return string time converted
*/
function formathour($time)
{
	if (!is_int($time)) return false;

	global $config;

	$date = date($config->sys->hour_format, $time);

	return $date;
}
