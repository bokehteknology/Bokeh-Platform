	<div id="sidebar">
		<div id="sidebar-bgtop"></div>
		<div id="sidebar-content">
			<ul>
				<li>
					<h2>{$l_install_informations}</h2>
					<ul>
						<li><a><b>{$l_install_host}</b>: <em>{$dbhost}</em></a></li>
						<li><a><b>{$l_install_port}</b>: <em>{$dbport}</em></a></li>
						<li><a><b>{$l_install_dbname}</b>: <em>{$dbname}</em></a></li>
						<li><a><b>{$l_username}</b>: <em>{$dbuser}</em></a></li>
						<li><a><b>{$l_password}</b>: <em>****</em></a></li>
						<li><a><b>{$l_install_table_prefix}</b>: <em>{$table_prefix}</em></a></li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="sidebar-bgbtm"></div>
	</div>
	<!-- end #sidebar -->
</div>
<!-- end #page -->
<div id="footer">
	<p>Powered by <a href="http://{$bokeh_site}">Bokeh Platform</a>, &copy; 2009, 2011<br />{$debug_info}</p>
</div>
<!-- end #footer -->
</body>
</html>