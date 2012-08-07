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
* Do a request to Bokeh API server
*
* @param string $service
* @param string $mode
* @param array $params
* @return mixed array response of api request (if executed)
*/
function api_request($service, $mode, $params = array(), $return_errors = true)
{
	global $bokeh_version;

	if (empty($service) || empty($mode))
	{
		return false;
	}

	if (!defined('APIKEY') || APIKEY == '')
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_APIKEY_NOT_SET');
		}
	}

	$post_data = array(
		'apikey' => APIKEY,
		'service' => $service,
		'mode' => $mode
	);

	$post_data += $params;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://api.bokehteknology.net/');
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, "Bokeh Platform | Host: {$_SERVER['SERVER_NAME']} | Version: {$bokeh_version}");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);

	$fetch = curl_exec($ch);

	curl_close($ch);

	if (!$fetch)
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_API_SERVER_OFFLINE');
		}
	}

	$response = json_decode($fetch, true);

	if (isset($response['error']) || (isset($response['news_type']) && $response['news_type'] == 0) || (isset($response['s_news_type']) && $response['s_news_type'] == 0))
	{
		if (!$return_errors)
		{
			return false;
		}
		else
		{
			error_box('ERR_API_REQUEST');
		}
	}

	return $response;
}

/**
* Retrive latest Bokeh Platform version
*
* @param bool $stable specific if we are using stable version or not
* @param bool $return_errors if true, if there are errors echo errors, else return false
* @return string latest version
*/
function retrive_latest_version($stable = true, $return_errors = true)
{
	$request = api_request('bokeh_platform', ($stable ? 'stable' : 'dev'), array(), $return_errors);

	return $request['version'];
}
