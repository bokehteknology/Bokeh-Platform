<?php
/**
*
* en [English]
*
* @plugin PluginManager
* @package PluginManager
* @copyright (c) 2012 Bokeh Platform
* @author Bokeh Teknology
* @version 1.0.1
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
	'PLUGIN_PLUGIN_MANAGER_TITLE'	=> 'Plugin Manager',

	'PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY'	=> 'You need explain mode passkey to access to Plugin Manager.<br />Add ?passkey=PASSKEY to URL.',
	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN'	=> 'No plugin specified.',
	'PLUGIN_PLUGIN_MANAGER_ERR_FILE'	=> 'The directory “plugins/plugin_manager/tmp” is not writable.',
	'PLUGIN_PLUGIN_MANAGER_ERR_ZIP'		=> 'We could not find the root of the plugin. Probably the ZIP archive is malformed.',
	'PLUGIN_PLUGIN_MANAGER_ERR_MOVE'	=> 'It was not possible to update the plugin. Check the permissions on the folder “plugins”.',

	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST'	=> 'The specified plugin does not exist.',
	'PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_EXIST_YET'	=> 'The specified plugin is already installed..',
	'PLUGIN_PLUGIN_MANAGER_ERR_THIS_PLUGIN'			=> 'You can not automatically update this plugin. You must manually update it.',
	'PLUGIN_PLUGIN_MANAGER_ERR_IS_ACTIVE'			=> 'You can not delete a plugin active. Disable it and try again.',

	'PLUGIN_PLUGIN_MANAGER_WELCOME'		=> 'Welcome',
	'PLUGIN_PLUGIN_MANAGER_REQUESTS'	=> 'Requests',

	'PLUGIN_PLUGIN_MANAGER_INSTALLED'	=> 'Plugins installed',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOAD'	=> 'Download plugins',

	'PLUGIN_PLUGIN_MANAGER_YES'			=> 'Yes',
	'PLUGIN_PLUGIN_MANAGER_NO'			=> 'No',

	'PLUGIN_PLUGIN_MANAGER_PLUGIN_ID'	=> 'Plugin ID',
	'PLUGIN_PLUGIN_MANAGER_NAME'		=> 'Name',
	'PLUGIN_PLUGIN_MANAGER_DESCRIPTION'	=> 'Description',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOADS'	=> 'Downloads',
	'PLUGIN_PLUGIN_MANAGER_VERSION'		=> 'Version',
	'PLUGIN_PLUGIN_MANAGER_AUTHOR'		=> 'Author',
	'PLUGIN_PLUGIN_MANAGER_IS_ACTIVE'	=> 'Enabled',
	'PLUGIN_PLUGIN_MANAGER_OPTIONS'		=> 'Options',
	'PLUGIN_PLUGIN_MANAGER_CONTROLLER'	=> 'Controller',
	'PLUGIN_PLUGIN_MANAGER_BRANCH'		=> 'Branch',

	'PLUGIN_PLUGIN_MANAGER_UPDATE'		=> 'Updating',
	'PLUGIN_PLUGIN_MANAGER_INSTALLING'	=> 'Installation',
	'PLUGIN_PLUGIN_MANAGER_DELETING'	=> 'Removing',

	'PLUGIN_PLUGIN_MANAGER_UPDATE_STARTING'		=> 'The update has started!<br />If the plug is large enough, the upgrade may take longer than 1 minute.',
	'PLUGIN_PLUGIN_MANAGER_INSTALL_STARTING'	=> 'The installation has started!<br />If the plug is large enough, the upgrade may take longer than 1 minute.',
	'PLUGIN_PLUGIN_MANAGER_DELETE_STARTING'		=> 'The plugin is being removed!<br />Wait a few moments.',
	'PLUGIN_PLUGIN_MANAGER_MSG_UPDATED'			=> 'The plugin was successfully updated!',
	'PLUGIN_PLUGIN_MANAGER_MSG_INSTALLED'		=> 'The plugin was successfully installed!',
	'PLUGIN_PLUGIN_MANAGER_MSG_DELETED'			=> 'The plugin was successfully removed!',
	'PLUGIN_PLUGIN_MANAGER_MSG_API_OFFLINE'		=> 'The API server is offline, so it was not possible to retrieve required information!',
	'PLUGIN_PLUGIN_MANAGER_MSG_DWL_OFFLINE'		=> 'We could not retrieve the plugin!',

	'PLUGIN_PLUGIN_MANAGER_DELETE'		=> 'Delete',
	'PLUGIN_PLUGIN_MANAGER_INSTALL'		=> 'Install',

	'PLUGIN_PLUGIN_MANAGER_INSTALLED_COUNT'		=> 'You have installed <strong>%d</strong> plugins (<strong>%d</strong> enabled).',
	'PLUGIN_PLUGIN_MANAGER_UPDATE_COUNT'		=> 'There are <strong>%d</strong> plugins not updated.',
	'PLUGIN_PLUGIN_MANAGER_DOWNLOADS_COUNT'		=> 'The database contains <strong>%d</strong> plugins (<strong>%d</strong> already installed).',

	'PLUGIN_PLUGIN_MANAGER_UPDATE_TO'	=> 'Update to',

	'PLUGIN_PLUGIN_MANAGER_NOT_REGISTERED'	=> 'not registered on BT forum',
));
