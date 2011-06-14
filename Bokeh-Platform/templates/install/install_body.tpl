
	<div id="content">
		<div class="post">
			<h1 class="title">{$l_install_details}</h1>
			<div class="entry">
				{if $install_errors == 'yes'}
					{$l_install_ok}<br />{$install_errors_list}<br /><br />
				{/if}
				
				{$l_install_ok}
			</div>
			<div class="meta">
				<p class="links"><a href="{$root_path}index.php" class="more">{$l_home}</a></p>
			</div>
		</div>
	</div>
	<!-- end #content -->
