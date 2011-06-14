
	<div id="content">
		<div class="post">
			<h1 class="title">{$l_install_details}</h1>
			<form action="{$root_path}install.php?mode=install" method="POST">
			<div class="entry">
				<fieldset><legend>{$l_site_info}</legend><table border="0">
					<tr><td>{$l_sitename}:</td><td><input type="text" value="{$sitename}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_site_description}:</td><td><input type="text" value="{$site_description}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_template}:</td><td><input type="text" value="{$_tpl}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_meta_description}:</td><td><input type="text" value="{$meta_description}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_meta_keywords}:</td><td><input type="text" value="{$meta_keywords}" size="50" readonly="yes" /></td></tr>
				</table></fieldset>
				<fieldset><legend>{$l_database_info}</legend><table border="0">
					<tr><td>{$l_install_type}:</td><td><input type="text" value="{$dbtype}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_install_host}:</td><td><input type="text" value="{$dbhost}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_install_port}:</td><td><input type="text" value="{$dbport}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_install_dbname}:</td><td><input type="text" value="{$dbname}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_username}:</td><td><input type="text" value="{$dbuser}" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_password}:</td><td><input type="password" value="******" size="50" readonly="yes" /></td></tr>
					<tr><td>{$l_install_table_prefix}:</td><td><input type="text" value="{$table_prefix}" size="50" readonly="yes" /></td></tr>
				</table></fieldset>
				<fieldset><legend>{$l_settings}</legend><table border="0">
					<tr><td>APIKEY:</td><td><input type="text" value="{$s_apikey}" size="40" readonly="yes" /></td></tr>
					<tr><td>DEBUG:</td><td><b>{$s_debug}</b></td></tr>
					<tr><td>DISPLAY_RAM:</td><td><b>{$s_display_ram}</b></td></tr>
					<tr><td>ERROR_HANLDER:</td><td><b>{$s_error_handler}</b></td></tr>
					<tr><td>EXPLAIN_MODE:</td><td><b>{$s_explain_mode}</b></td></tr>
					<tr><td>ENABLE_PLUGINS:</td><td><b>{$s_enable_plugins}</b></td></tr>
					<tr><td>ENABLE_SEO:</td><td><b>{$s_enable_seo}</b></td></tr>
				</table></fieldset>

			</div>
			<div class="meta">
				<p class="links"><input type="submit" name="submit" value="{$l_install_install}" /></p>
			</div>
			</form>
		</div>
	</div>
	<!-- end #content -->
