/*
TPL Name: {$tpl_name}
TPL Author: {$tpl_author}
TPL Website: {$tpl_website}
*/

body {
	margin: 0px;
	padding: 0px;
	background: #fcf5f5 url({$tpl_path}images/img01.gif) repeat-x left top;
	font: 13px Arial, Helvetica, sans-serif;
	color: #660000;
}

h1, h2, h3 {
	margin-top: 0px;
}

h1 {
	font-size: 2.4em;
}

h2 {
	font-size: 1.8em;
}

h3 {
	font-size: 1.4em;
}

p, ol, ul {
	margin-bottom: 1.8em;
	line-height: 160%;
}

a {
	color: #a32626;
}

a:hover {
	text-decoration: none;
	color: #FF0000;
}

a img {
	border: none;
}

/* Header */

#header {
	width: 900px;
	height: 100px;
	margin: 0px auto;
}

#header a {
	text-decoration: none;
	color: #FFFFFF;
}

/* Logo */

#logo {
	float: left;
}

#logo h1, #logo p {
	margin: 0px;
	line-height: normal;
	font-weight: normal;
	color: #FFFFFF;
}

#logo h1 {
	padding: 25px 0px 0px 0px;
}

/* Menu */

#menu {
	float: right;
}

#menu ul {
	margin: 0px;
	padding: 49px 0px 0px 0px;
	list-style: none;
	line-height: normal;
}

#menu li {
	float: left;
	margin: 0px 0px 0px 1px;
}

#menu a {
	display: block;
	width: auto;
	height: 28px;
	padding: 12px 20px 0px 20px;
}

#menu a:hover {
	text-decoration: underline;
}

#menu .active {
	background: #a32626 url({$tpl_path}images/img02.gif) no-repeat 0px 0px;
}

#menu .active a {
	background: url({$tpl_path}images/img02.gif) no-repeat 100% -40px;
}

/* Page */

#page {
	width: 900px;
	margin: 0px auto;
	padding: 30px 0px;
}

/* Content */

#content {
	float: right;
	width: 570px;
}

.post {
	margin: 0px 0px 30px 0px;
}

.post .title {
	margin: 0px;
	padding: 0px 0px 5px 0px;
	border-bottom: 1px solid #c49090;
}

.post .entry {
}

.post .meta {
	font-weight: bold;
}

.post .byline {
	margin: 0px;
}

/* Sidebar */

#sidebar {
	float: left;
	width: 300px;
	background: url({$tpl_path}images/img03.gif) repeat-y left top;
}

#sidebar-bgtop {
	height: 3px;
	background: url({$tpl_path}images/img04.gif) no-repeat left top;
}

#sidebar-bgbtm {
	height: 3px;
	background: url({$tpl_path}images/img05.gif) no-repeat left bottom;
}

#sidebar-content {
	padding: 20px;
}

#sidebar ul {
	margin: 0px;
	padding: 0px;
	list-style: none;
}

#sidebar li ul {
	margin-bottom: 1.8em;
	list-style: inside disc;
}

#sidebar h2 {
	font-size: 1.4em;
}

#sidebar a {
	text-decoration: none;
}

#sidebar a:hover {
	text-decoration: underline;
}

/* Search */

#search {
}

#search form {
	margin-bottom: 1.8em;
	padding: 0px;
}

#search fieldset {
	margin: 0px;
	padding: 0px;
	border: none;
}

#search #s {
	width: 160px;
}

/* Footer */

#footer {
	clear: both;
	width: 900px;
	height: 50px;
	margin: 0px auto 30px auto;
	background: #c23939 url({$tpl_path}images/img06.gif) no-repeat left top;
	color: #FFFFFF;
}

#footer p {
	margin: 0px;
	padding: 19px 0px 0px 0px;
	text-align: center;
	line-height: normal;
	font-size: smaller;
}

#footer a {
	color: #FFFFFF;
}