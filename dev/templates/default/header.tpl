<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>{$sitename} - {$title}</title>
<meta name="keywords" content="{$meta_keywords}" />
<meta name="description" content="{$meta_description}" />
<link href="{$root_path}style.php" rel="stylesheet" type="text/css" media="screen" />

<!--

Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Title      : Concrete
Version    : 1.0
Released   : 20080825
Description: A Web 2.0 design with fluid width suitable for blogs and small websites.

-->

<!--
* Bokeh Platform Template
* Name: {$tpl_name}
* Author: {$tpl_author}
* Website: {$tpl_website}
-->

</head>
<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="{$root_path}index.php">{$sitename}</a></h1>
		<p><a>{$site_description}</a></p>
	</div>
	<div id="menu">
		<ul>
			<li><a href="{$root_path}index.php">Home</a></li>
			<li class="last"><a href="{$root_path}style.php">CSS</a></li>
		</ul>
	</div>
</div>
<!-- end header -->
<!-- start page -->
<div id="page">
	<!-- start sidebar -->
	<div id="sidebar">
		<ul>
			<li id="search" style="background: none;">
				<form id="searchform" method="get" action="">
					<div>
						<input type="text" name="s" id="s" size="15" />
						<br />
						<input type="submit" value="{$l_blog_search}" />
					</div>
				</form>
			</li>
			<li id="categories">
				<h2>{$l_categories}</h2>
				<ul>
					<li><a>{$l_blog_no_cats}</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- end sidebar -->