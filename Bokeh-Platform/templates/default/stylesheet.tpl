/*
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License
Edited for Bokeh Platform

TPL Name: {$tpl_name}
TPL Author: {$tpl_author}
TPL Website: {$tpl_website}
*/

body {
	margin: 0;
	padding: 0;
	background: #FFFFFF url({$tpl_path}images/img01.jpg) repeat-x;
	text-align: justify;
	font: 15px Arial, Helvetica, sans-serif;
	color: #626262;
}

form {
	margin: 0;
	padding: 0;
}

input {
	padding: 5px;
	background: #FEFEFE url({$tpl_path}images/img13.gif) repeat-x;
	border: 1px solid #626262;
	font: normal 1em Arial, Helvetica, sans-serif;
}

h1, h1 a, h2, h2 a, h3, h3 a {
	margin: 0;
	text-decoration: none;
	font-family: Tahoma, Georgia, "Times New Roman", Times, serif;
	font-weight: normal;
	color: #444444;
}

h1 {
	letter-spacing: -1px;
	font-size: 2.2em;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

h2 {
	letter-spacing: -1px;
	font-size: 2em;
}

h3 {
	font-size: 1em;
}

p, ol, ul {
	margin-bottom: 2em;
	line-height: 200%;
}

blockquote {
	margin: 0 0 0 1.5em;
	padding-left: 1em;
	border-left: 5px solid #DDDDDD;
}

a {
	color: #1692B8;
}

a:hover {
	text-decoration: none;
}

/* Header */

#header {
	height: 42px;
}

#logo h1, #logo p {
	float: left;
	text-transform: lowercase;
}

#logo h1 {
	padding: 0px 0 0 40px;
}

#logo p {
	margin: 0;
	padding: 14px 0 0 4px;
	line-height: normal;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}

#logo a {
	text-decoration: none;
	color: #D0C7A6;
}

#menu {
	float: right;
}

#menu ul {
	margin: 0;
	padding: 0;
	list-style: none;
}

#menu li {
	display: block;
	float: left;
	height: 42px;
}

#menu a {
	display: block;
	padding: 8px 20px 0px 20px;
	text-decoration: none;
	text-align: center;
	text-transform: lowercase;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: normal;
	font-size: 14px;
	color: #CEC5A4;
}

#menu .last {
	margin-right: 20px;
}

#menu a:hover {
	color: #FFFFFF;
}

#menu .current_page_item {
}

#menu .current_page_item a {
}

/* Page */

#page {
	padding: 40px 40px 0 40px;
}

/* Content */

#content {
	margin-right: 340px;
}

.post {
	margin-bottom: 10px;
}

.post .title {
	border-bottom: 1px #999999 dashed;
	font-family: Tahoma, Georgia, "Times New Roman", Times, serif;
}

.post .title h2 {
	padding: 30px 30px 0 0px;
	text-transform: lowercase;
	font-weight: normal;
	font-size: 2.2em;
}

.post .title p {
	margin: 0;
	padding: 0 0 10px 0px;
	line-height: normal;
	color: #BABABA;
}

.post .title p a {
	color: #BABABA;
}

.post .entry {
	padding: 20px 0px 20px 0px;
}

.post .links {
	margin: 0;
	padding: 0 30px 30px 0px;
}

.post .links a {
	display: block;
	float: left;
	margin-right: 10px;
	margin-bottom: 5px;
	text-align: center;
	text-decoration: none;
	font-weight: bold;
	color: #FFFFFF;
}

.post .links a:hover {
}

.post .links .more {
	width: 128px;
	height: 30px;
	background: url({$tpl_path}images/img03.jpg) no-repeat left center;
}

.post .links .comments {
	width: 152px;
	height: 30px;
	background: url({$tpl_path}images/img04.jpg) no-repeat left center;
}

/* Sidebar */

#sidebar {
	float: right;
	width: 300px;
	margin-top: 30px;
}

#sidebar ul {
	margin: 0;
	padding: 0;
	list-style: none;
}

#sidebar li {
	margin-bottom: 10px;
	background: url({$tpl_path}images/img10.gif) no-repeat left bottom;
}

#sidebar li ul {
	padding: 0 30px 40px 30px;
}

#sidebar li li {
	margin: 0;
	padding-left: 20px;
	background: url({$tpl_path}images/img11.gif) no-repeat 5px 50%;
}

#sidebar h2 {
	padding: 30px 30px 20px 30px;
	background: url({$tpl_path}images/img09.gif) no-repeat;
	text-transform: lowercase;
	font-weight: normal;
	font-size: 1.6em;
	color: #302D26;
}


/* Search */

#search {
	padding: 20px 30px 40px 30px;
}

#search input {
	padding: 0;
	width: 70px;
	height: 29px;
	background: #DFDFDF url({$tpl_path}images/img14.gif) repeat-x;
	font-weight: bold;
}

#search #s {
	padding: 5px;
	width: 150px;
	height: auto;
	background: #FEFEFE url({$tpl_path}images/img13.gif) repeat-x;
	border: 1px solid #626262;
	font: normal 1em Arial, Helvetica, sans-serif;
}

#search br {
	display: none;
}

/* Categories */

#sidebar #categories li {
	background: url({$tpl_path}images/img12.gif) no-repeat left center;
}

/* Calendar */

#calendar_wrap {
	padding: 0 30px 40px 30px;
}

#calendar table {
	width: 100%;
	text-align: center;
}

#calendar thead {
	background: #F1F1F1;
}

#calendar tbody td {
	border: 1px solid #F1F1F1;
}

#calendar #prev {
	text-align: left;
}

#calendar #next {
	text-align: right;
}

#calendar tfoot a {
	text-decoration: none;
	font-weight: bold;
}

#calendar #today {
	background: #FFF3A7;
	border: 1px solid #EB1400;
	font-weight: bold;
	color: #EB1400
}

/* Footer */

#footer {
	padding: 70px 0 50px 0;
	background: #757575 url({$tpl_path}images/img08.gif) repeat-x;
}

#footer p {
	margin-bottom: 1em;
	text-align: center;
	line-height: normal;
	font-size: .9em;
	color: #BABABA;
}

#footer a {
	padding: 0 20px;
	text-decoration: none;
	color: #DDDDDD;
}

#footer a:hover {
	color: #FFFFFF;
}

#footer .rss {
	background: url({$tpl_path}images/img18.gif) no-repeat left center;
}

#footer .xhtml {
	background: url({$tpl_path}images/img19.gif) no-repeat left center;
}

#footer .css {
	background: url({$tpl_path}images/img20.gif) no-repeat left center;
}

#footer .legal a {
	padding: 0;
}