<?php
/**
*
* @package PluginManager
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

class plugin_plugin_manager extends plugin
{
	public $plugin_id = 'plugin_manager';

	function _configure()
	{
		$this->is_controller = true;
		$this->load_lang = true;
	}

	function index()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		$this->plugin->assign('page', 'index');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		if (request_var('status') && !empty($_REQUEST['status']))
		{
			$this->plugin->assign('msg_status', addslashes($_REQUEST['status']));
		}
		else if (request_var('err') && !empty($_REQUEST['err']))
		{
			$this->plugin->assign('msg_err', addslashes($_REQUEST['err']));
		}

		$plugins_installed = array();

		$count_installed = 0;
		$count_active = 0;
		$count_update = 0;

		foreach(glob($root_path . 'plugins/*', GLOB_ONLYDIR) as $_directory_path)
		{
			$_plugin_name = str_replace($root_path . 'plugins/', '', $_directory_path);
			$_plugin_cfg = $_directory_path . '/' . $_plugin_name . '.cfg';

			if (file_exists($_plugin_cfg))
			{
				$plugins_installed += parse_ini_file($_plugin_cfg, true);
				$plugins_installed[$_plugin_name]['active'] = in_array($_plugin_name, $config->sys->plugins);

				$plugin_details = api_request('plugin_manager', 'details', array('plugin_id' => $_plugin_name));
				$plugins_installed[$_plugin_name]['plugin_name'] = $_plugin_name;
				
				if (!$plugin_details)
				{
					$user_info = api_request('user', 'info');
					$plugins_installed[$_plugin_name]['author_username'] = $user_info['username'];
					unset($user_info);
				}
				else
				{
					$plugins_installed[$_plugin_name]['author_username'] = $plugin_details['username'];
				}

				$plugins_installed[$_plugin_name]['font_color'] = !isset($plugin_details['version']) ? 'black' : (version_compare($plugin_details['version'], $plugins_installed[$_plugin_name]['version'], '>') ? 'red' : 'green');

				if (isset($plugin_details['version']) && version_compare($plugin_details['version'], $plugins_installed[$_plugin_name]['version'], '>'))
				{
					$count_update++;
				}

				$count_installed++;

				if ($plugins_installed[$_plugin_name]['active'])
				{
					$count_active++;
				}
			}
			else
			{
				// Nothing for now
			}
		}

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('plugins_installed', $plugins_installed);
		$this->plugin->assign('count_installed', $count_installed);
		$this->plugin->assign('count_active', $count_active);
		$this->plugin->assign('count_update', $count_update);
		$this->plugin->assign('installed_string', sprintf($this->plugin->language('PLUGIN_PLUGIN_MANAGER_INSTALLED_COUNT'), $count_installed, $count_active));
		$this->plugin->assign('update_string', sprintf($this->plugin->language('PLUGIN_PLUGIN_MANAGER_UPDATE_COUNT'), $count_update));

		$this->plugin->view('header');
		$this->plugin->view('home_body');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function details_installed()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (!file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST');
		}

		$this->plugin->assign('page', 'details');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');
		
		$_plugin_cfg = $root_path . 'plugins/' . $plugin_id . '/' . $plugin_id . '.cfg';
		$_plugin_info = parse_ini_file($_plugin_cfg);

		$_plugin_info['plugin_name'] = $plugin_id;
		$_plugin_info['active'] = in_array($plugin_id, $config->sys->plugins);

		$plugin_details = api_request('plugin_manager', 'details', array('plugin_id' => $plugin_id));

		if (!$plugin_details)
		{
			$user_info = api_request('user', 'info');
			$_plugin_info['author_username'] = $user_info['username'];
			unset($user_info);
		}
		else
		{
			$_plugin_info['author_username'] = $plugin_details['username'];
		}

		$_plugin_info['font_color'] = !isset($plugin_details['version']) ? 'black' : (version_compare($plugin_details['version'], $_plugin_info['version'], '>') ? 'red' : 'green');

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('author_id', $_plugin_info['author_id']);
		$this->plugin->assign('plugin_title', $_plugin_info['title']);
		$this->plugin->assign('plugin_id', $plugin_id);
		$this->plugin->assign('update_plugin', (version_compare($plugin_details['version'], $_plugin_info['version'], '>') ? true : false));
		$this->plugin->assign('new_version', $plugin_details['version']);

		$this->plugin->assign('plugin_info', array(
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_PLUGIN_ID')		=> $plugin_id,
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_DESCRIPTION')	=> $_plugin_info['description'],
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_VERSION')		=> "<span style=\"color: {$_plugin_info['font_color']}\"><strong>{$_plugin_info['version']}</strong></span>",
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_IS_ACTIVE')		=> $_plugin_info['active'] ? $this->plugin->language('PLUGIN_PLUGIN_MANAGER_YES') : $this->plugin->language('PLUGIN_PLUGIN_MANAGER_NO'),
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_CONTROLLER')		=> $_plugin_info['is_controller'] ? $this->plugin->language('PLUGIN_PLUGIN_MANAGER_YES') : $this->plugin->language('PLUGIN_PLUGIN_MANAGER_NO'),
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_AUTHOR')			=> isset($_plugin_info['author_username']) ? "<a href=\"http://www.bokehteknology.net/community/memberlist.php?mode=viewprofile&u={$_plugin_info['author_id']}\">{$_plugin_info['author_username']}</a>" : "<em>({$this->plugin->language('PLUGIN_PLUGIN_MANAGER_NOT_REGISTERED')})</em>",
		));

		$this->plugin->view('header');
		$this->plugin->view('details');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function start_update()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (!file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST');
		}

		if ($plugin_id == 'plugin_manager')
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_THIS_PLUGIN');
		}

		$this->plugin->assign('page', 'start_update');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('meta', "<meta http-equiv=\"refresh\" content=\"5; url={$config->sys->site_root}plugin_manager/update?passkey={$_REQUEST['passkey']}&plugin_id={$_REQUEST['plugin_id']}\" />");

		$this->plugin->view('header');
		$this->plugin->view('update_is_starting');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function update()
	{
		global $root_path, $config, $_REQUEST;

		include($root_path . 'plugins/plugin_manager/pclzip.lib.php');
		include($root_path . 'plugins/plugin_manager/functions.php');

		@set_time_limit(0);

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (!file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST');
		}

		if ($plugin_id == 'plugin_manager')
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_THIS_PLUGIN');
		}

		$this->plugin->assign('page', 'download');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$tmp_dir = $root_path . 'plugins/' . $this->plugin_id . '/tmp/';
		$tmp_file = $tmp_dir . $plugin_id . '.zip';
		$tmp_fileExtracted = $tmp_dir . $plugin_id . '/';
		$tmp_pluginDir = $root_path . 'plugins/' . $plugin_id . '/';

		# Get download link
		$dwInfo = api_request('plugin_manager', 'download', array('plugin_id' => $plugin_id));

		if (!$dwInfo)
		{
			header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&err=server_offline");
		}

		if (file_exists($tmp_file))
		{
			@unlink($tmp_file);
		}

		if (file_exists($tmp_fileExtracted))
		{
			_delete_directory($tmp_fileExtracted);
		}

		# Start downloading ZIP file
		$dwHandle = @curl_init($dwInfo['download']);

		if (!$dwHandle)
		{
			header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&err=download_offline");
		}
		else
		{
			$fileHandle = @fopen($tmp_file, 'wb');

			if (!$fileHandle)
			{
				error_box('PLUGIN_PLUGIN_MANAGER_ERR_FILE');
			}
			else
			{
				curl_setopt($dwHandle, CURLOPT_FILE, $fileHandle);
				curl_setopt($dwHandle, CURLOPT_BUFFERSIZE, (1024 * 8));
				curl_setopt($dwHandle, CURLOPT_HEADER, false);

				curl_exec($dwHandle);

				fclose($fileHandle);
				curl_close($dwHandle);
			}
		}

		# Extract downloaded ZIP
		$zip = new PclZip($tmp_file);
		$zip->extract(PCLZIP_OPT_PATH, $tmp_dir);

		# Search plugin root (determined by a directory called $plugin_id
		# that containts files $plugin_id.cfg and $plugin_id.php
		$tmp_fileExtracted = _plugin_root($tmp_dir, $plugin_id);

		# Check if directory structure is correct
		if ($tmp_fileExtracted == null)
		{
			# First empty Plugin Manager tmp directory
			_delete_directory($tmp_dir, false);

			# After send error to user
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_ZIP');
		}

		# Delete new plugin directory if exist
		if (file_exists($tmp_pluginDir))
		{
			_delete_directory($tmp_pluginDir);
		}

		# Move new plugin to plugins directory
		$moveDir = rename(substr($tmp_fileExtracted, 0, -1), substr($tmp_pluginDir, 0, -1));

		if (!$moveDir)
		{
			# First empty Plugin Manager tmp directory
			_delete_directory($tmp_dir, false);

			# After send error to user
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_MOVE');
		}

		# Empty Plugin Manager tmp directory
		_delete_directory($tmp_dir, false);

		# Plugin updated successfully!
		header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&status=plugin_updated");
	}

	function start_delete()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (!file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST');
		}

		if (in_array($plugin_id, $config->sys->plugins))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_IS_ACTIVE');
		}

		$this->plugin->assign('page', 'start_delete');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('meta', "<meta http-equiv=\"refresh\" content=\"5; url={$config->sys->site_root}plugin_manager/delete?passkey={$_REQUEST['passkey']}&plugin_id={$_REQUEST['plugin_id']}\" />");

		$this->plugin->view('header');
		$this->plugin->view('delete_is_starting');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function delete()
	{
		global $root_path, $config, $_REQUEST;

		include($root_path . 'plugins/plugin_manager/functions.php');

		@set_time_limit(0);

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (!file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_NOT_EXIST');
		}

		if (in_array($plugin_id, $config->sys->plugins))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_IS_ACTIVE');
		}

		$this->plugin->assign('page', 'delete');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$tmp_pluginDir = $root_path . 'plugins/' . $plugin_id . '/';

		# Remove plugin
		if (file_exists($tmp_pluginDir))
		{
			_delete_directory($tmp_pluginDir);
		}

		# Plugin removed successfully!
		header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&status=plugin_deleted");
	}

	function download()
	{
		global $root_path, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		$this->plugin->assign('page', 'download');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$plugins_installed = array();

		foreach(glob($root_path . 'plugins/*', GLOB_ONLYDIR) as $_directory_path)
		{
			$plugins_installed[] = str_replace($root_path . 'plugins/', '', $_directory_path);
		}

		$plugins_installable = array();
		$count_downloads = 0;
		$count_installed = 0;

		$dwlList = api_request('plugin_manager', 'list');

		foreach($dwlList as $_plugin_name => $_plugin_data)
		{
			$count_downloads++;

			if (!in_array($_plugin_name, $plugins_installed))
			{
				$plugins_installable[$_plugin_name] = $_plugin_data;
			}
			else
			{
				$count_installed++;
			}
		}

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('plugins_installable', $plugins_installable);
		$this->plugin->assign('count_downloads', $count_downloads);
		$this->plugin->assign('count_installed', $count_installed);
		$this->plugin->assign('downloads_string', sprintf($this->plugin->language('PLUGIN_PLUGIN_MANAGER_DOWNLOADS_COUNT'), $count_downloads, $count_installed));

		$this->plugin->view('header');
		$this->plugin->view('downloads');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function start_install()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_EXIST_YET');
		}

		$this->plugin->assign('page', 'start_install');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('meta', "<meta http-equiv=\"refresh\" content=\"5; url={$config->sys->site_root}plugin_manager/install?passkey={$_REQUEST['passkey']}&plugin_id={$_REQUEST['plugin_id']}\" />");

		$this->plugin->view('header');
		$this->plugin->view('install_is_starting');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}

	function install()
	{
		global $root_path, $config, $_REQUEST;

		include($root_path . 'plugins/plugin_manager/pclzip.lib.php');
		include($root_path . 'plugins/plugin_manager/functions.php');

		@set_time_limit(0);

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_EXIST_YET');
		}

		$this->plugin->assign('page', 'install');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$tmp_dir = $root_path . 'plugins/' . $this->plugin_id . '/tmp/';
		$tmp_file = $tmp_dir . $plugin_id . '.zip';
		$tmp_fileExtracted = $tmp_dir . $plugin_id . '/';
		$tmp_pluginDir = $root_path . 'plugins/' . $plugin_id . '/';

		# Get download link
		$dwInfo = api_request('plugin_manager', 'download', array('plugin_id' => $plugin_id));

		if (!$dwInfo)
		{
			header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&err=server_offline");
		}

		if (file_exists($tmp_file))
		{
			@unlink($tmp_file);
		}

		if (file_exists($tmp_fileExtracted))
		{
			_delete_directory($tmp_fileExtracted);
		}

		# Start downloading ZIP file
		$dwHandle = @curl_init($dwInfo['download']);

		if (!$dwHandle)
		{
			header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&err=download_offline");
		}
		else
		{
			$fileHandle = @fopen($tmp_file, 'wb');

			if (!$fileHandle)
			{
				error_box('PLUGIN_PLUGIN_MANAGER_ERR_FILE');
			}
			else
			{
				curl_setopt($dwHandle, CURLOPT_FILE, $fileHandle);
				curl_setopt($dwHandle, CURLOPT_BUFFERSIZE, (1024 * 8));
				curl_setopt($dwHandle, CURLOPT_HEADER, false);

				curl_exec($dwHandle);

				fclose($fileHandle);
				curl_close($dwHandle);
			}
		}

		# Extract downloaded ZIP
		$zip = new PclZip($tmp_file);
		$zip->extract(PCLZIP_OPT_PATH, $tmp_dir);

		# Search plugin root (determined by a directory called $plugin_id
		# that containts files $plugin_id.cfg and $plugin_id.php
		$tmp_fileExtracted = _plugin_root($tmp_dir, $plugin_id);

		# Check if directory structure is correct
		if ($tmp_fileExtracted == null)
		{
			# First empty Plugin Manager tmp directory
			_delete_directory($tmp_dir, false);

			# After send error to user
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_ZIP');
		}

		# Delete new plugin directory if exist (it's checked yet, but add for security)
		if (file_exists($tmp_pluginDir))
		{
			_delete_directory($tmp_pluginDir);
		}

		# Move new plugin to plugins directory
		$moveDir = rename(substr($tmp_fileExtracted, 0, -1), substr($tmp_pluginDir, 0, -1));

		if (!$moveDir)
		{
			# First empty Plugin Manager tmp directory
			_delete_directory($tmp_dir, false);

			# After send error to user
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_MOVE');
		}

		# Empty Plugin Manager tmp directory
		_delete_directory($tmp_dir, false);

		# Plugin updated successfully!
		header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&status=plugin_installed");
	}

	function details_download()
	{
		global $root_path, $config, $_REQUEST;

		if (!defined('EXPLAIN_MODE_PASSKEY') || (defined('EXPLAIN_MODE_PASSKEY') && EXPLAIN_MODE_PASSKEY == '') || !request_var('passkey') || (request_var('passkey') && $_REQUEST['passkey'] != EXPLAIN_MODE_PASSKEY))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PASSKEY');
		}

		if (!request_var('plugin_id') || empty($_REQUEST['plugin_id']))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN');
		}

		$plugin_id = $_REQUEST['plugin_id'];

		if (file_exists($root_path . 'plugins/' . $plugin_id . '/'))
		{
			error_box('PLUGIN_PLUGIN_MANAGER_ERR_PLUGIN_EXIST_YET');
		}

		$this->plugin->assign('page', 'details');
		$this->plugin->assign('title', $this->plugin->language('PLUGIN_PLUGIN_MANAGER_TITLE'));
		$this->plugin->assign('plugin_templateDir', 'plugins/' . $this->plugin_id . '/views/');

		$plugin_details = api_request('plugin_manager', 'details', array('plugin_id' => $plugin_id));

		if (!$plugin_details)
		{
			header("Location: {$config->sys->site_root}plugin_manager?passkey={$_REQUEST['passkey']}&err=server_offline");
		}

		$user_info = api_request('user', 'info');

		$this->plugin->assign('api_user_id', $user_info['user_id']);
		$this->plugin->assign('api_username', $user_info['username']);
		$this->plugin->assign('api_reqRemained', $user_info['reqRemained']);

		$this->plugin->assign('url_passkey', "?passkey={$_REQUEST['passkey']}");

		$this->plugin->assign('author_id', $plugin_details['user_id']);
		$this->plugin->assign('plugin_title', $plugin_details['name']);
		$this->plugin->assign('plugin_id', $plugin_details['plugin_id']);
		$this->plugin->assign('install_plugin', true);

		$this->plugin->assign('plugin_info', array(
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_PLUGIN_ID')		=> $plugin_details['plugin_id'],
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_AUTHOR')			=> "<a href=\"http://www.bokehteknology.net/community/memberlist.php?mode=viewprofile&u={$plugin_details['user_id']}\">{$plugin_details['username']}</a>",
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_DESCRIPTION')	=> $plugin_details['description'],
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_VERSION')		=> "<strong>{$plugin_details['version']}</strong>",
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_DOWNLOADS')		=> "<strong>{$plugin_details['downloads']}</strong>",
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_BRANCH')			=> $plugin_details['branch'],
			$this->plugin->language('PLUGIN_PLUGIN_MANAGER_CONTROLLER')		=> $plugin_details['is_controller'] ? $this->plugin->language('PLUGIN_PLUGIN_MANAGER_YES') : $this->plugin->language('PLUGIN_PLUGIN_MANAGER_NO'),
		));

		$this->plugin->view('header');
		$this->plugin->view('details');

		output_debug();

		$this->plugin->view('footer');

		close(false);
	}
}
