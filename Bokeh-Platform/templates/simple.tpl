<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="{$l_lang_prefix}" xml:lang="{$l_lang_prefix}">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-style-type" content="text/css" />
		<meta http-equiv="content-language" content="{$l_lang_prefix}" />
		<meta http-equiv="imagetoolbar" content="no" />
		<meta name="resource-type" content="document" />
		<meta name="distribution" content="global" />
		<meta name="copyright" content="{$current_year}, Bokeh Teknology. Tutti i diritti riservati." />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		
		<title>Bokeh Platform - {$title}</title>
		
		<style type="text/css">
		<!--
		body         { font-family: Verdana; color: #000000; font-size:8pt; background-color:#ffffff }
		a:active     { font-weight:bold; color:#000000 }
		a:link       { font-weight:bold; color:#000000 }
		a:visited    { font-weight:bold; color:#000000 }
		table        { padding-top:1; padding-bottom:1; padding-left:2; padding-right:2 }
		tr           { }
		td           { font-family:Verdana; font-size:8pt }
		th           { font-family:Verdana; font-size:12pt; font-weight:bold; color:#808080; text-align:left; margin-left:8; margin-bottom:4 }
		h1           { padding:0; font-size:16pt;  }
		h2           { border-style:outset; border-width:1; font-size:14pt }
		h3           { font-size:12pt; border-left-width:1; border-right-width:1; border-top-width:1; border-bottom-style:solid; border-bottom-width:1 }
		html		 { font-size:8pt }
		.BorderOn	 { width:90px; margin-left:0px; color:#000000; background-color:#B0B0B0; font-size:8pt; font-family:Verdana }
		.BorderOff	 { width:90px; margin-left:0px; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }
		.title		 { position: relative; width: 100px; height: 10px; z-index: 10; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }
		.submenu	 { padding:0; position: relative; left: 10px; width: 90px; color:#000000; background-color:#DDDDDD; font-size:8pt; font-family:Verdana }
		.gradient01  { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#4B92D9', endColorStr='#CEDFF6', gradientType='1') }
		.gradient02	 { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#CEDFF6', endColorStr='#1E77D3', gradientType='1') }
		.gradient03	 { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#0A6CCE', endColorStr='#FFFFFF', gradientType='1') }
		.gradient04  { filter:progid:DXImageTransform.Microsoft.Gradient(startColorStr='#CCCCCC', endColorStr='#EEEEEE', gradientType='1') }
		.bodygray    { font-family: Verdana; color: #000000; font-size:8pt; background-color:#dddddd }
		.bodylgray   { font-family: Verdana; color: #000000; font-size:8pt; background-color:#eeeeee }
		// -->
		</style>
	</head>
	<body>
		<h1>Bokeh Platform</h1>
		<h3>{$title}</h3>
		<p>{$template_html}</p>
		
		<p style="text-align: right"><em>
		Powered by <a href="http://{$bokeh_site}/">Bokeh Teknology</a>, 2009, {$current_year}<br />
		{$l_translation_info}<br />
		{$debug_info}
		</em></p>
	</body>
</html>