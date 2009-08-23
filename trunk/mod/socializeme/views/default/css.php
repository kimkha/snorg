<?php

	/**
	 * Elgg example theme
	 * core CSS file 
	 * 
	 * Updated 9 March 09
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 * 
	 * @uses $vars['wwwroot'] The site URL
	 */

?>

/* ***************************************
	RESET BASE STYLES
*************************************** */
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-weight: inherit;
	font-style: inherit;
	font-size: 100%;
	font-family: inherit;
	vertical-align: baseline;
}
/* remember to define focus styles! */
:focus {
	outline: 0;
}
ol, ul {
	list-style: none;
}
/* tables still need cellspacing="0" (for ie6) */
table {
	border-collapse: separate;
	border-spacing: 0;
}
caption, th, td {
	text-align: left;
	font-weight: normal;
	vertical-align: top;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: "";
}
blockquote, q {
	quotes: "" "";
}
.clearfloat { 
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;
}

/* ***************************************
	DEFAULTS
*************************************** */

/* elgg open source		blue 			#2779e7 */
/* elgg open source		dark blue 		#2779e7 */
/* elgg open source		light yellow 	#FDFFC3 */
/* elgg open source		light blue	 	#c5e3ff */


body {
	text-align:left;
	margin:0 auto;
	padding:0;
	background: #FAFAFA;
	font: 80%/1.4  "Lucida Grande", Verdana, sans-serif;
	color: #333333;
}
a {
	color:#2779e7;
	text-decoration: none;
	-moz-outline-style: none;
	outline: none;
}
a:visited {
	
}
a:hover {
	color: #333;
}
p {
	margin: 0px 0px 15px 0;
}
img {
	border: none;
}
ul {
	margin: 5px 0px 15px;
	padding-left: 20px;
}
ul li {
	margin: 0px;
}
ol {
	margin: 5px 0px 15px;
	padding-left: 20px;
}
ul li {
	margin: 0px;
}
form {
	margin: 0px;
	padding: 0px;
}
small {
	font-size: 82%;
}
h1, h2, h3, h4, h5, h6 {
	font-weight: bold;
	line-height: normal;
}
h1 { font-size: 1.8em; }
h2 { font-size: 1.5em; }
h3 { font-size: 1.2em; }
h4 { font-size: 1.0em; }
h5 { font-size: 0.9em; }
h6 { font-size: 0.8em; }

dt {
	margin: 0;
	padding: 0;
	font-weight: bold;
}
dd {
	margin: 0 0 1em 1em;
	padding: 0;
}
pre, code {
	font-family:Monaco,"Courier New",Courier,monospace;
	font-size:12px;
	background:#EBF5FF;
	overflow:auto;
}
code {
	padding:2px 3px;
}
pre {
	padding:3px 15px;
	margin:0px 0 15px 0;
	line-height:1.3em;
}
blockquote {
	padding:3px 15px;
	margin:0px 0 15px 0;
	line-height:1.3em;
	background:#EBF5FF;
	border:none !important;

}
blockquote p {
	margin:0 0 5px 0;
}

/* ***************************************
    PAGE LAYOUT - MAIN STRUCTURE
*************************************** */
#page_container {
	margin:0;
    padding:0;
	background:#fff url(<?php echo $vars['url']; ?>mod/socializeme/graphics/pageback.png) repeat-x top;
}
#page_wrapper {
	width:980px;
	margin:0 auto;
	padding:0;
	min-height: 300px;

}
#layout_header {
  height:135px;
  margin-bottom:0;
  text-align:left;
  width:100%;
	/* background:#dedede; */
}
#wrapper_header {
	margin:0;
	padding:10px 20px 10px 0px;
}
#wrapper_header h1,
#wrapper_header h1 a {
	margin:10px 0 0 0;
	letter-spacing: -0.03em;
	color:white;
}
#layout_canvas {
	margin:0 0 10px 0;
	padding:10px;
	min-height: 360px;
    -webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	background: #e9e9e9;
	border:1px solid #cccccc;
    
}


/* canvas layout: 1 column, no sidebar */
#one_column {
/* 	width:960px; */
	margin:0;
	min-height: 360px;
	background: #FFF;
	padding:0 0 10px 0;

}

/* canvas layout: 2 column left sidebar */
#two_column_left_sidebar {
	width:210px;
	margin:0 20px 0 0;
    min-height:360px;
	float:left;
	padding:0px;

}

#two_column_left_sidebar_maincontent {
	width:725px;
	margin:0;
	min-height: 360px;
	float:left;
	padding:0 0 5px 0;
	background:#f5f5f5;
border:1px solid #ccc;
   	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;	
}

#two_column_left_sidebar_maincontent_boxes {
	margin:0 0px 20px 20px;
	padding:0 0 5px 0;
	width:720px;
	float:left;
}
#two_column_left_sidebar_boxes {
	width:210px;
	margin:0px 0 20px 0px;
	min-height:360px;
	float:left;
	padding:0;
}
#two_column_left_sidebar_boxes .sidebarBox {
	margin:0px;
    width:210px;
    padding:4px 5px 5px 5px;
}
#two_column_left_sidebar_boxes .sidebarBox h3 {
	padding:5px;
    background:#333;
	font-size:12px;
	line-height:16px;
	color:#fff;
}

.contentWrapper {
	background:#fff; 
    border:1px solid #ccc;
       	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;	
    padding:10px;
    margin:0 10px 10px 10px;
}
span.contentIntro p {
	margin:0 0 0 0;
}
.notitle {
	margin-top:10px;
}

/* canvas layout: widgets (profile and dashboard) */
#widgets_left {
	width:300px;
	margin:0 20px 20px 0;
	min-height:360px;
	padding:0;
}
#widgets_middle {
	width:310px;
	margin:0 0 20px 0;
	padding:0;
}
#widgets_right {
	width:310px;
	margin:0px 0 20px 20px;
	float:left;
	padding:0;
}
#widget_table td {
	border:0;
	padding:0;
	margin:0;
	text-align: left;
	vertical-align: top;
}
/* IE6 fixes */
* html #widgets_right { float:none; }
* html #profile_info_column_left {
	margin:0 10px 0 0;
	width:200px;
}
* html #dashboard_info { width:585px; }
/* IE7 */
*:first-child+html #profile_info_column_left { width:200px; }


/* ***************************************
	SPOTLIGHT
*************************************** */
#layout_spotlight {
	margin:20px 0 20px 0;
	padding:0;
	background: white;
	border:1px solid #cccccc;
}
#wrapper_spotlight {
	margin:0;
	padding:0;
	height:auto;
}
#wrapper_spotlight #spotlight_table h2 {
	color:#000000;
	font-size:1.25em;
	line-height:1.2em;
}
#wrapper_spotlight #spotlight_table li {
	list-style: square;
	line-height: 1.2em;
	margin:5px 20px 5px 0;
	color:#555555;
}
#wrapper_spotlight .collapsable_box_content  {
	margin:0;
	padding:10px 10px 5px 10px;
	background:none;
	min-height:60px;
	border:none;
	border-top:1px solid #cccccc;
}
#spotlight_table {
	margin:0 0 2px 0;
}
#spotlight_table .spotlightRHS {
	float:right;
	width:270px;
	margin:0 0 0 50px;
}
/* IE7 */
*:first-child+html #wrapper_spotlight .collapsable_box_content {
	width:958px;
}
#layout_spotlight .collapsable_box_content p {
	padding:0;
}
#wrapper_spotlight .collapsable_box_header  {
	border: none;

}


/* ***************************************
	FOOTER
*************************************** */
#layout_footer {
	background: #333;
	height:80px;
	margin:0 0 40px 0;
}
#layout_footer table {
   margin:0 0 0 20px;
}
#layout_footer a, #layout_footer p {
   color:#fff;
   margin:0;
}
#layout_footer .footer_toolbar_links {
	text-align:right;
	padding:15px 0 0 0;
	font-size:.9em;
}
#layout_footer .footer_legal_links {
	text-align:right;
}


/* ***************************************
  HORIZONTAL ELGG TOPBAR
*************************************** */
#elgg_topbar {
   	background:#333333;
	//*color:#eeeeee;*//
	border-bottom:2px solid #f5f5f5;
	min-width:998px;
	position:relative;
	width:100%;
	height:24px;
	z-index: 9000; /* if you have multiple position:relative elements, then IE sets up separate Z layer contexts for each one, which ignore each other */
}
#elgg_topbar_container_left {
	float:left;
	height:24px;
	left:0px;
	top:0px;
	position:absolute;
	text-align:left;
	width:60%;
}
#elgg_topbar_container_right {
	float:right;
	height:24px;
	position:absolute;
	right:0px;
	top:0px;
	/* width:120px;*/
	text-align:right;
}
#elgg_topbar_container_search {
	float:right;
	height:21px;
	/*width:280px;*/
	position:relative;
	right:120px;
	text-align:right;
	margin:3px 0 0 0;
}
#elgg_topbar_container_left .toolbarimages {
	float:left;
	margin-right:20px;
}
#elgg_topbar_container_left .toolbarlinks {
	margin:0 0 10px 0;
	float:left;
}
#elgg_topbar_container_left .toolbarlinks2 {
	margin:3px 0 0 0;
	float:left;
}
#elgg_topbar_container_left a.loggedinuser {
	color:#eeeeee;
	font-weight:bold;
	margin:0 0 0 5px;
}
#elgg_topbar_container_left a.pagelinks {
	color:white;
	margin:0 15px 0 5px;
	display:block;
	padding:3px;
}
#elgg_topbar_container_left a.pagelinks:hover {
	background: #2779e7;
	text-decoration: none;
}
#elgg_topbar_container_left a.privatemessages {
	background:transparent url(<?php echo $vars['url']; ?>_graphics/toolbar_messages_icon.gif) no-repeat left 2px;
	padding:0 0 4px 16px;
	margin:0 15px 0 5px;
	cursor:pointer;
}
#elgg_topbar_container_left a.privatemessages:hover {
	text-decoration: none;
	background:transparent url(<?php echo $vars['url']; ?>_graphics/toolbar_messages_icon.gif) no-repeat left -36px;
}
#elgg_topbar_container_left a.privatemessages_new {
	background:transparent url(<?php echo $vars['url']; ?>_graphics/toolbar_messages_icon.gif) no-repeat left -17px;
	padding:0 0 0 18px;
	margin:0 15px 0 5px;
	color:white;
}
/* IE6 */
* html #elgg_topbar_container_left a.privatemessages_new { background-position: left -18px; } 
/* IE7 */
*+html #elgg_topbar_container_left a.privatemessages_new { background-position: left -18px; } 

#elgg_topbar_container_left a.privatemessages_new:hover {
	text-decoration: none;
}

#elgg_topbar_container_left a.usersettings {
	margin:0 0 0 20px;
	color:#2779e7;
    font-weight:bold;
	padding:3px;
}
#elgg_topbar_container_left a.usersettings:hover {
	color:#FFF;
        font-weight:bold;

}
#elgg_topbar_container_left img {
	margin:0 0 0 5px;
}
#elgg_topbar_container_left .user_mini_avatar {
	border:1px solid #eeeeee;
	margin:0 0 0 20px;
}
#elgg_topbar_container_right {
	padding:3px 0 0 0;
}
#elgg_topbar_container_right a {
	color:#eeeeee;
	margin:0 5px 0 0;
	background:transparent url(<?php echo $vars['url']; ?>_graphics/elgg_toolbar_logout.gif) no-repeat top right;
	padding:0 21px 0 0;
	display:block;
	height:20px;
}
/* IE6 fix */
* html #elgg_topbar_container_right a { 
	width: 120px;
}
#elgg_topbar_container_right a:hover {
	background-position: right -21px;
}
#elgg_topbar_panel {
	background:#333333;
	color:#eeeeee;
	height:200px;
	width:100%;
	padding:10px 20px 10px 20px;
	display:none;
	position:relative;
}
#searchform input.search_input {
	background-color:#FFFFFF;
	color:#999999;
	font-size:12px;
	font-weight:bold;
	margin:0pt;
	padding:2px;
	width:180px;
	height:12px;
}
#searchform input.search_submit_button {
	color:#fff;
	background: #2779e7;
	border:none;
	font-size:12px;
	font-weight:bold;
	margin:0px;
	padding:2px;
	width:auto;
	height:18px;
	cursor:pointer;
}
#searchform input.search_submit_button:hover {
	color:#333;
	background: #ccc;
}


/* ***************************************
	TOP BAR - VERTICAL TOOLS MENU
*************************************** */
/* elgg toolbar menu setup */
ul.topbardropdownmenu, ul.topbardropdownmenu ul {
	margin:0;
	padding:0;
	display:inline;
	float:left;
	list-style-type: none;
	z-index: 9000;
	position: relative;
}
ul.topbardropdownmenu {
	margin:0pt 20px 0pt 5px;
}
ul.topbardropdownmenu li { 
	display: block;
	list-style: none;
	margin: 0;
	padding: 0;
	float: left;
	position: relative;
}
ul.topbardropdownmenu a {
	display:block;
}
ul.topbardropdownmenu ul {
	display: none;
	position: absolute;
	left: 0;
	margin: 0;
	padding: 0;
}
/* IE6 fix */
* html ul.topbardropdownmenu ul {
	line-height: 1.1em;
}
/* IE6/7 fix */
ul.topbardropdownmenu ul a {
	zoom: 1;
} 
ul.topbardropdownmenu ul li {
	float: none;
}   
/* elgg toolbar menu style */
ul.topbardropdownmenu ul {
	width: 150px;
	top: 24px;
	border-top:1px solid black;
}
ul.topbardropdownmenu *:hover {
	background-color: none;
}
ul.topbardropdownmenu a {
	padding:3px;
	text-decoration:none;
	color:white;
}
ul.topbardropdownmenu li.hover a {
 background: #2779e7 ;
	text-decoration: none;
}
ul.topbardropdownmenu ul li.drop a {
	font-weight: normal;
}
/* IE7 fixes */
*:first-child+html #elgg_topbar_container_left a.pagelinks {

}
*:first-child+html ul.topbardropdownmenu li.drop a.menuitemtools {
	padding-bottom:6px;
}
ul.topbardropdownmenu ul li a {
	background-color: #333333;/* menu off state color */
	font-weight: bold;
	padding-left:6px;
	padding-top:4px;
	padding-bottom:0;
	height:22px;
	border-bottom: 1px solid white;
}
ul.topbardropdownmenu ul a.hover {
	background-color: #333;
}
ul.topbardropdownmenu ul a {
	opacity: 1;
	filter: alpha(opacity=90);
}


/* ***************************************
  SYSTEM MESSSAGES
*************************************** */
.messages {
    background:#ccffcc;
    color:#000000;
    padding:3px 10px 3px 10px;
    z-index: 8000;
	margin:0;
	position:fixed;
	top:30px;
	width:969px;
	border:4px solid #00CC00;
	cursor: pointer;
}
.messages_error {
    border:4px solid #D3322A;
    background:#F7DAD8;
    color:#000000;
    padding:3px 10px 3px 10px;
    z-index: 8000;
	margin:0;
	position:fixed;
	top:30px;
	width:969px;
	cursor: pointer;
}
.closeMessages {
	float:right;
	margin-top:17px;
}
.closeMessages a {
	color:#666666;
	cursor: pointer;
	text-decoration: none;
	font-size: 80%;
}
.closeMessages a:hover {
	color:black;
}


/* ***************************************
  COLLAPSABLE BOXES
*************************************** */
.collapsable_box {
	margin: 0 0 20px 0;
	height:auto;

}
/* IE6 fix */
* html .collapsable_box  { 
	height:10px;
}
.collapsable_box_header {
background:#fff;
border-bottom:2px solid #2779e7;
color:#2779e7;
height:19px;
margin:0;
padding:4px 12px 2px;
}
.collapsable_box_header h1 {
	color: #2779e7;
	font-size:1.0em;
	line-height: 1.2em;
}
.collapsable_box_content {
background:#f5f5f5 none repeat scroll 0 0;
height:auto;
margin:0;
padding:10px 0;
	border-left: 1px solid #cccccc;
	border-right: 1px solid #cccccc;
	border-bottom: 1px solid #cccccc;
}
.collapsable_box_content .contentWrapper {
	margin-bottom:5px;
    
}
.collapsable_box_editpanel {
	display: none;
	background: #f5f5f5;
	padding:10px 10px 5px 10px;
	border: 1px solid #CCC;
}
.collapsable_box_editpanel p {
	margin:0 0 5px 0;
}
.collapsable_box_header a.toggle_box_contents {
	color: #2779e7;
	cursor:pointer;
	font-family: Arial, Helvetica, sans-serif;
	font-size:20px;
	font-weight: bold;
	text-decoration:none;
	float:right;
	margin: 0;
	margin-top: -7px;
}
.collapsable_box_header a.toggle_box_edit_panel {
	color: #2779e7;
	cursor:pointer;
	font-size:9px;
	text-transform: uppercase;
	text-decoration:none;
	font-weight: normal;
	float:right;
	margin: 3px 10px 0 0;
}
.collapsable_box_editpanel label {
	font-weight: normal;
	font-size: 100%;
}
/* used for collapsing a content box */
.display_none {
	display:none;
}
/* used on spotlight box - to cancel default box margin */
.no_space_after {
	margin: 0 0 0 0;
}



/* ***************************************
	GENERAL FORM ELEMENTS
*************************************** */
label {
	font-weight: bold;
	color:#333333;
	font-size: 90%;
}
input {
	font: 120% Arial, Helvetica, sans-serif;
	padding: 5px;
    margin:5px;
	border: 1px solid #cccccc;
	color:#666666;
}

textarea {
	font: 120% Arial, Helvetica, sans-serif;
	border: solid 1px #cccccc;
	padding: 5px;
	color:#666666;
}
textarea:focus, input[type="text"]:focus {
	border: solid 1px #999999;
	background: #f5f5f5;
	color:#333333;
}
.submit_button {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#2779e7;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
    border:none;
	margin:10px 0 10px 0;
	cursor: pointer;
}
.submit_button:hover, input[type="submit"]:hover {
	background: #333;
}

input[type="submit"] {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#2779e7;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
	margin:10px 0 10px 0;
	cursor: pointer;
}
.cancel_button {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #999999;
	background:#dddddd;
	border: 1px solid #999999;
	width: auto;
	height: 25px;
	padding: 2px 6px 2px 6px;
	margin:10px 0 10px 10px;
	cursor: pointer;
}
.cancel_button:hover {
	background: #cccccc;
}

.input-text,
.input-tags,
.input-url,
.input-textarea {
	width:98%;
}

.input-textarea {
	height: 200px;
}


/* ***************************************
	LOGIN / REGISTER
*************************************** */
#login-box {
	margin:0 0 10px 0;
	padding:0 0 10px 0;
	background: #000000;
	width:240px;
    text-align:left;
}
#login-box form {
	margin:0 10px 0 10px;
	padding:0 10px 4px 10px;
	background: white;
	width:200px;
}
#login-box h2 {
	color:#FFFFFF;
	font-size:1.35em;
	line-height:1.2em;
	margin:0 0 0 8px;
	padding:5px 5px 0 5px;
}
#login-box .login-textarea {
	width:250px;
}
#login-box label {
font-size: 1.2em;
color:grey;
}
#register-box label {
	font-size: 1.2em;
	color:#555555;
}
#login-box p.loginbox {
	margin:0;
}
#login-box input[type="text"],
#login-box input[type="password"],
#register-box input[type="text"],
#register-box input[type="password"] {
	margin:0 0 10px 0;
}
#register-box input[type="text"],
#register-box input[type="password"] {
	width:380px;
}
#login-box h2,
#login-box-openid h2,
#register-box h2,
#add-box h2,
#forgotten_box h2 {
	color:#000000;
	font-size:1.35em;
	line-height:1.2em;
	margin:0pt 0pt 5px;
}
#register-box {
    text-align:left;
    width:400px;
    padding:10px;
    margin:0;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
}
#persistent_login label {
	font-size:1.0em;
	font-weight: normal;
}
/* login and openID boxes when not running custom_index mod */
#two_column_left_sidebar #login-box {
	width:auto;
	background: none;
}
#two_column_left_sidebar #login-box form {
	width:auto;
	margin:10px 10px 0 10px;
	padding:5px 0 5px 10px;
}
#two_column_left_sidebar #login-box h2 {
	margin:0 0 0 5px;
	padding:5px 5px 0 5px;
}
#two_column_left_sidebar #login-box .login-textarea {
	width:158px;
}


/* ***************************************
	PROFILE
*************************************** */
#profile_info {
	margin:0 0 20px 0;
	padding:20px;
	border:1px solid #cccccc;
	background: #c5e3ff;

}
#profile_info_column_left {
	float:left;
	padding: 0;
	margin:0 20px 0 0;
}
#profile_info_column_middle {
background:#FFFFFF none repeat scroll 0 0;
border:1px solid #AAAAAA;
float:left;
padding:13px;
width:330px;
margin-bottom:10px;
}
#profile_info_column_right {
background:#FFFFFF none repeat scroll 0 0;
border:1px solid #AAAAAA;
margin:0;
padding:16px;
width:554px;
}
#dashboard_info {
	margin:0px 0px 0 0px;
	padding:20px;
	border-bottom:1px solid #cccccc;
	border-right:1px solid #cccccc;
	background: #c5e3ff;
}
#profile_menu_wrapper {
	margin:5px 0 5px 0;
	width:200px;
    border:1px solid #ccc;
	padding: 2px;
    
    }
#profile_menu_wrapper p {
	background: #2779e7;
    border-bottom:1px dotted #fff;

}
#profile_menu_wrapper p:first-child {
}

#profile_menu_wrapper a {
	display:block;
    color:white;
	padding:0 0 0 3px;
}
#profile_menu_wrapper a:hover {
    background: #333;
	color:#fff;
	text-decoration:none;
}
p.user_menu_friends, p.user_menu_profile, 
p.user_menu_removefriend, 
p.user_menu_friends_of {
	margin:0;
}
#profile_menu_wrapper .user_menu_admin {
	border-top:none;
}

#profile_info_column_middle p {
	margin:7px 0 7px 0;
	padding:2px 4px 2px 4px;
}
/* profile owner name */
#profile_info_column_middle h2 {
	padding:0 0 14px 0;
	margin:0;
}
#profile_info_column_middle .profile_status {
	background:#fff5b1;
	padding:2px 4px 2px 4px;
	line-height:1.2em;
}
#profile_info_column_middle .profile_status span {
	display:block;
	font-size:90%;
	color:#666666;	
}
#profile_info_column_middle a.status_update {
	float:right;	
}
#profile_info_column_middle .odd {
}
#profile_info_column_middle .even {

}
#profile_info_column_right p {
	margin:0 0 7px 0;
}
#profile_info_column_right .profile_aboutme_title {
	margin:0;
	padding:0;
	line-height:1em;
}
/* edit profile button */
.profile_info_edit_buttons {
	float:right;
	margin:0  !important;
	padding:0 !important;
}
.profile_info_edit_buttons a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#2779e7;
	width: auto;
	padding: 2px 6px 2px 6px;
	margin:0;
	cursor: pointer;
}
.profile_info_edit_buttons a:hover {
	background: #333;
	text-decoration: none;
	color:white;
}


/* ***************************************
	RIVER
*************************************** */
#river,
.river_item_list {
	border:1px solid #ccc;
    padding:5px;
    
}
.river_item p {
	margin:0;
	padding:0 0 0 21px;
	line-height:1.1em;
	min-height:17px;
}
.river_item {
	border-bottom:1px solid #dddddd;
	padding:2px 0 2px 0;
}
.river_item_time {
	font-size:90%;
	color:#666666;
}
/* IE6 fix */
* html .river_item p { 
	padding:3px 0 3px 20px;
}
/* IE7 */
*:first-child+html .river_item p {
	min-height:17px;
}
.river_user_update {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_profile.gif) no-repeat left -1px;
}
.river_object_user_profileupdate {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_profile.gif) no-repeat left -1px;
}
.river_object_user_profileiconupdate {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_profile.gif) no-repeat left -1px;
}
.river_object_annotate {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_bookmarks_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_bookmarks.gif) no-repeat left -1px;
}
.river_object_bookmarks_comment {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_status_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_status.gif) no-repeat left -1px;
}
.river_object_file_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_files.gif) no-repeat left -1px;
}
.river_object_file_update {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_files.gif) no-repeat left -1px;
}
.river_object_file_comment {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_widget_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;
}
.river_object_forums_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_object_forums_update {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_object_widget_update {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_plugin.gif) no-repeat left -1px;	
}
.river_object_blog_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_blog.gif) no-repeat left -1px;
}
.river_object_blog_update {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_blog.gif) no-repeat left -1px;
}
.river_object_blog_comment {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_forumtopic_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_user_friend {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_friends.gif) no-repeat left -1px;
}
.river_object_relationship_friend_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_friends.gif) no-repeat left -1px;
}
.river_object_relationship_member_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_object_thewire_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_thewire.gif) no-repeat left -1px;
}
.river_group_join {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_object_groupforumtopic_annotate {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_groupforumtopic_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_forum.gif) no-repeat left -1px;
}
.river_object_sitemessage_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_blog.gif) no-repeat left -1px;	
}
.river_user_messageboard {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;	
}
.river_object_page_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_pages.gif) no-repeat left -1px;
}
.river_object_page_top_create {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_pages.gif) no-repeat left -1px;
}
.river_object_page_top_comment {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}
.river_object_page_comment {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/river_icons/river_icon_comment.gif) no-repeat left -1px;
}

/* ***************************************
	SEARCH LISTINGS	
*************************************** */
.search_listing {
	display: block;
	background:#f5f5f5; 
    border:1px solid #ccc;
    margin:0 10px 5px 10px;
	padding:5px;
}
.search_listing_icon {
	float:left;
}
.search_listing_icon img {
	width: 40px;
}
.search_listing_icon .avatar_menu_button img {
	width: 15px;
}
.search_listing_info {
	margin-left: 50px;
	min-height: 40px;
}
/* IE 6 fix */
* html .search_listing_info {
	height:40px;
}
.search_listing_info p {
	margin:0 0 3px 0;
	line-height:1.2em;
}
.search_listing_info p.owner_timestamp {
	margin:0;
	padding:0;
	color:#666666;
	font-size: 90%;
}
table.search_gallery {
	border-spacing: 10px;
	margin:0 0 0 0;
}
.search_gallery td {
	padding: 5px;
}
.search_gallery_item {
	background: white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	width:170px;
}
.search_gallery_item:hover {
	background: black;
	color:white;
}
.search_gallery_item .search_listing {
	background: none;
	text-align: center;
}
.search_gallery_item .search_listing_header {
	text-align: center;
}
.search_gallery_item .search_listing_icon {
	position: relative;
	text-align: center;
}
.search_gallery_item .search_listing_info {
	margin: 5px;
}
.search_gallery_item .search_listing_info p {
	margin: 5px;
	margin-bottom: 10px;
}
.search_gallery_item .search_listing {
	background: none;
	text-align: center;
}
.search_gallery_item .search_listing_icon {
	position: absolute;
	margin-bottom: 20px;
}
.search_gallery_item .search_listing_info {
	margin: 5px;
}
.search_gallery_item .search_listing_info p {
	margin: 5px;
	margin-bottom: 10px;
}


/* ***************************************
	FRIENDS
*************************************** */
/* friends widget */
#widget_friends_list {
	display:table;
	width:275px;
	margin:0 10px 0 10px;
	padding:8px 0 4px 8px;
	background:white;
}
.widget_friends_singlefriend {
	float:left;
	margin:0 5px 5px 0;
}


/* ***************************************
	ADMIN AREA - PLUGIN SETTINGS
*************************************** */
.plugin_details {
	margin:0 10px 5px 10px;
	padding:0 7px 4px 10px;
	-webkit-border-radius: 5px; 
	-moz-border-radius: 5px;
}
.admin_plugin_reorder {
	float:right;
	width:200px;
	text-align: right;
}
.admin_plugin_reorder a {
	padding-left:10px;
	font-size:80%;
	color:#999999;
}
.plugin_details a.pluginsettings_link {
	cursor:pointer;
	font-size:80%;
}
.active {
	border:1px solid #999999;
    background:white;
}
.not-active {
    border:1px solid #999999;
    background:#dedede;
}
.plugin_details p {
	margin:0;
	padding:0;
}
.plugin_details a.manifest_details {
	cursor:pointer;
	font-size:80%;
}
.manifest_file {
	background:#dedede;
	padding:5px 10px 5px 10px;
	margin:4px 0 4px 0;
	display:none;
}
.admin_plugin_enable_disable {
	width:150px;
	margin:10px 0 0 0;
	float:right;
	text-align: right;
}
.contentIntro .enableallplugins,
.contentIntro .disableallplugins {
	float:right;
}
.contentIntro .enableallplugins {
	margin-left:10px;
}
.contentIntro .enableallplugins, 
.not-active .admin_plugin_enable_disable a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#2779e7;
	width: auto;
	padding: 4px;
    margin-right:5px;
	cursor: pointer;
}
.contentIntro .enableallplugins:hover, 
.not-active .admin_plugin_enable_disable a:hover {
	background: #2779e7;
    text-decoration: none;
}
.contentIntro .disableallplugins, 
.active .admin_plugin_enable_disable a {
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
        margin-right:5px;

	background:#999999;
	border: 1px solid #999999;
	width: auto;
	padding: 4px;
	cursor: pointer;
}
.contentIntro .disableallplugins:hover, 
.active .admin_plugin_enable_disable a:hover {
	background: #2779e7;
	border: 1px solid #333333;
	text-decoration: none;
}
.pluginsettings {
	margin:15px 0 5px 0;
	background:#c5e3ff;
	padding:10px;
	display:none;
}
.pluginsettings h3 {
	padding:0 0 5px 0;
	margin:0 0 5px 0;
	border-bottom:1px solid #999999;
}
#updateclient_settings h3 {
	padding:0;
	margin:0;
	border:none;
}
.input-access {
	margin:5px 0 0 0;
}

/* ***************************************
	GENERIC COMMENTS
*************************************** */
.generic_comment_owner {
	font-size: 90%;
	color:#666666;
}
.generic_comment {
	background:#fff;
    padding:10px;
    border:1px solid #ccc;
    margin:0 10px 10px 10px;
}
.generic_comment_icon {
	float:left;
}
.generic_comment_details {
	margin-left: 60px;
}
.generic_comment_details p {
	margin: 0 0 5px 0;
}
.generic_comment_owner {
	color:#666666;
	margin: 0px;
	font-size:90%;
	border-top: 1px solid #aaaaaa;
}
/* IE6 */
* html #generic_comment_tbl { width:676px !important;}

	
/* ***************************************
  PAGE-OWNER BLOCK
*************************************** */
#owner_block {
  margin-top:2px;
}
#owner_block_icon {
	float:left;
	margin:0 10px 0 0;
}
#owner_block_rss_feed,
#owner_block_odd_feed,
#owner_block_bookmark_this,
#owner_block_report_this {
	padding:5px 0 0 0;
}
#owner_block_report_this {
	padding-bottom:5px;
	}
#owner_block_rss_feed a {
	font-size: 90%;
	color:#333;
	padding:0 0 4px 20px;
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_rss.gif) no-repeat left top;
}
#owner_block_odd_feed a {
	font-size: 90%;
	color:#FFFFFF;
	padding:0 0 4px 20px;
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_odd.gif) no-repeat left top;
}
#owner_block_bookmark_this a {
	font-size: 90%;
	color:#333;
	padding:0 0 4px 20px;
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_bookmarkthis.gif) no-repeat left top;
}
#owner_block_report_this a {
	font-size: 90%;
	color:#333;
	padding:0 0 4px 20px;
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_reportthis.gif) no-repeat left top;
}
#owner_block_rss_feed a:hover,
#owner_block_odd_feed a:hover,
#owner_block_bookmark_this a:hover,
#owner_block_report_this a:hover {
	color: #2779e7;
}
#owner_block_desc {
	padding:4px 3px 4px 5px;
	margin:0 0 0 0;
	line-height: 1.2em;
	color:#666666;
		-moz-border-radius-bottomleft:4px;
-moz-border-radius-bottomright:4px;
-moz-border-radius-topleft:4px;
-moz-border-radius-topright:4px;
background:#FFFFFF none repeat scroll 0 0;
border:1px solid #AAAAAA;
}
#owner_block_content {
	margin:0 0 4px 0;
	padding:3px 0 0 0;
	min-height:35px;
	font-weight: bold;
}
#owner_block_content a {
	line-height: 1em;
	color:#000000;
}
.ownerblockline {
	padding:0;
	margin:0;
	//*border-bottom:1px solid #cccccc;*//
	height:1px;
}
#owner_block_submenu {
	margin:20px 0 20px 0;
    -webkit-border-radius: 10px; 
	-moz-border-radius: 10px;
    background:#fff;
    border:1px solid #ccc;
	padding: 5px;
	width:200px;
}
#owner_block_submenu ul {
	list-style: none;
	padding: 0;
	margin: 0;
}
#owner_block_submenu ul li.selected a {
	background: #2779e7;
	color:white;
}
#owner_block_submenu ul li.selected a:hover {
	background: #2779e7;
	color:white;
}
#owner_block_submenu ul li a {
	text-decoration: none;
	display: block;
	margin: 2px 0 0 0;
	color:#000000;
	padding:4px 6px 4px 10px;
	font-weight: bold;
	line-height: 1.1em;
	-webkit-border-radius: 10px; 
	-moz-border-radius: 10px;
}
#owner_block_submenu ul li a:hover {
	color:white;
	background: #333;
}

/* IE 6 + 7 menu arrow position fix */
* html #owner_block_submenu ul li.selected a {
	background-position: left 10px;
}
*:first-child+html #owner_block_submenu ul li.selected a {
	background-position: left 8px;
}

#owner_block_submenu .submenu_group {
	margin:10px 0 0 0;
	padding-bottom: 10px;
}

#owner_block_submenu .submenu_group .submenu_group_filter ul li a,
#owner_block_submenu .submenu_group .submenu_group_filetypes ul li a {
	color:#555555;
}
#owner_block_submenu .submenu_group .submenu_group_filter ul li.selected a,
#owner_block_submenu .submenu_group .submenu_group_filetypes ul li.selected a {
	background:#999999;
	color:white;
}
#owner_block_submenu .submenu_group .submenu_group_filter ul li a:hover,
#owner_block_submenu .submenu_group .submenu_group_filetypes ul li a:hover {
	color:white;
	background: #999999;
}


/* ***************************************
	PAGINATION
*************************************** */
.pagination {
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	background:white;
	margin:5px 10px 5px 10px;
	padding:5px;
}
.pagination .pagination_number {
	display:block;
	float:left;
	background:#ffffff;
	border:1px solid #2779e7;
	text-align: center;
	color:#2779e7;
	font-size: 12px;
	font-weight: normal;
	margin:0 6px 0 0;
	padding:0px 4px;
	cursor: pointer;
}
.pagination .pagination_number:hover {
	background:#2779e7;
	color:white;
	text-decoration: none;
}
.pagination .pagination_more {
	display:block;
	float:left;
	background:#ffffff;
	border:1px solid #ffffff;
	text-align: center;
	color:#2779e7;
	font-size: 12px;
	font-weight: normal;
	margin:0 6px 0 0;
	padding:0px 4px;
}
.pagination .pagination_previous,
.pagination .pagination_next {
	display:block;
	float:left;
	border:1px solid #2779e7;
	color:#2779e7;
	text-align: center;
	font-size: 12px;
	font-weight: normal;
	margin:0 6px 0 0;
	padding:0px 4px;
	cursor: pointer;
}
.pagination .pagination_previous:hover,
.pagination .pagination_next:hover {
	background:#2779e7;
	color:white;
	text-decoration: none;
}
.pagination .pagination_currentpage {
	display:block;
	float:left;
	background:#2779e7;
	border:1px solid #2779e7;
	text-align: center;
	color:white;
	font-size: 12px;
	font-weight: bold;
	margin:0 6px 0 0;
	padding:0px 4px;
	cursor: pointer;
}

	
/* ***************************************
	FRIENDS COLLECTIONS ACCORDIAN
*************************************** */	
ul#friends_collections_accordian {
	margin: 0 0 0 0;
	padding: 0;
}
#friends_collections_accordian li {
	margin: 0 0 0 0;
	padding: 0;
	list-style-type: none;
	color: #666666;
}
#friends_collections_accordian li h2 {
	background:#2779e7;
	color: white;
	padding:4px 2px 4px 6px;
	margin:10px 0 10px 0;
	font-size:1.2em;
	cursor:pointer;
}
#friends_collections_accordian li h2:hover {
	background:#333333;
	color:white;
}
#friends_collections_accordian .friends_picker {
	background:white;
	padding:0;
	display:none;
}
#friends_collections_accordian .friends_collections_controls {
	font-size:70%;
	float:right;
}
#friends_collections_accordian .friends_collections_controls a {
	color:#999999;
	font-weight:normal;
}
	
	
/* ***************************************
	FRIENDS PICKER SLIDER
*************************************** */		
.friendsPicker_container h3 {
	font-size:4em !important;
	text-align: left;
	margin:0 0 10px 0 !important;
	color:#999999 !important;
	background: none !important;
	padding:0 !important;
}
.friendsPicker .friendsPicker_container .panel ul {
	text-align: left;
	margin: 0;
	padding:0;
}
.friendsPicker_wrapper {
	margin: 0;
	padding:0;
	position: relative;
	width: 100%;
}
.friendsPicker {
	position: relative;
	overflow: hidden; 
	margin: 0;
	padding:0;
	width: 678px;
	
	height: auto;
	background: #dedede;
}
.friendspicker_savebuttons {
	background: white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	margin:0 10px 10px 10px;
}
.friendsPicker .friendsPicker_container { /* long container used to house end-to-end panels. Width is calculated in JS  */
	position: relative;
	left: 0;
	top: 0;
	width: 100%;
	list-style-type: none;
}
.friendsPicker .friendsPicker_container .panel {
	float:left;
	height: 100%;
	position: relative;
	width: 678px;
	margin: 0;
	padding:0;
}
.friendsPicker .friendsPicker_container .panel .wrapper {
	margin: 0;
	padding:4px 10px 10px 10px;
	min-height: 230px;
}
.friendsPickerNavigation {
	margin: 0 0 10px 0;
	padding:0;
}
.friendsPickerNavigation ul {
	list-style: none;
	padding-left: 0;
}
.friendsPickerNavigation ul li {
	float: left;
	margin:0;
	background:white;
}
.friendsPickerNavigation a {
	font-weight: bold;
	text-align: center;
	background: white;
	color: #999999;
	text-decoration: none;
	display: block;
	padding: 0;
	width:20px;
}
.tabHasContent {
	background: white; color:#333333 !important;
}
.friendsPickerNavigation li a:hover {
	background: #333333;
	color:white !important;
}
.friendsPickerNavigation li a.current {
	background: #4690D6;
	color:white !important;
}
.friendsPickerNavigationAll {
	margin:0px 0 0 20px;
	float:left;
}
.friendsPickerNavigationAll a {
	font-weight: bold;
	text-align: left;
	font-size:0.8em;
	background: white;
	color: #999999;
	text-decoration: none;
	display: block;
	padding: 0 4px 0 4px;
	width:auto;
}
.friendsPickerNavigationAll a:hover {
	background: #4690D6;
	color:white;
}
.friendsPickerNavigationL, .friendsPickerNavigationR {
	position: absolute;
	top: 46px;
	text-indent: -9000em;
}
.friendsPickerNavigationL a, .friendsPickerNavigationR a {
	display: block;
	height: 43px;
	width: 43px;
}
.friendsPickerNavigationL {
	right: 48px;
	z-index:1;
}
.friendsPickerNavigationR {
	right: 0;
	z-index:1;
}
.friendsPickerNavigationL {
	background: url("<?php echo $vars['url']; ?>mod/socializeme/graphics/friends_picker_arrows.gif") no-repeat left top;
}
.friendsPickerNavigationR {
	background: url("<?php echo $vars['url']; ?>mod/socializeme/graphics/friends_picker_arrows.gif") no-repeat -60px top;
}
.friendsPickerNavigationL:hover {
	background: url("<?php echo $vars['url']; ?>mod/socializeme/graphics/friends_picker_arrows.gif") no-repeat left -44px;
}
.friendsPickerNavigationR:hover {
	background: url("<?php echo $vars['url']; ?>mod/socializeme/graphics/friends_picker_arrows.gif") no-repeat -60px -44px;
}	
.friends_collections_controls a.delete_collection {
	display:block;
	cursor: pointer;
	width:14px;
	height:14px;
	margin:2px 3px 0 0;
	background: url("<?php echo $vars['url']; ?>_graphics/icon_customise_remove.png") no-repeat 0 0;
}
.friends_collections_controls a.delete_collection:hover {
	background-position: 0 -16px;
}
.friendspicker_savebuttons .submit_button,
.friendspicker_savebuttons .cancel_button {
	margin:5px 20px 5px 5px;
}

#collectionMembersTable {
	background: #dedede;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	margin:10px 0 0 0;
	padding:10px 10px 0 10px;
}

	
/* ***************************************
  WIDGET PICKER (PROFILE & DASHBOARD)
*************************************** */
/* 'edit page' button */
a.toggle_customise_edit_panel { 
	float:right;
	clear:right;
    	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	color: #fff;
    font-weight:bold;
	background: #2779e7;
	padding: 5px 10px 5px 10px;
	margin:0 0 20px 0;
	width:100px;
	text-align: center;
}
a.toggle_customise_edit_panel:hover { 
	color: #ffffff;
	background: #333;
	text-decoration:none;
}
#customise_editpanel {
	display:none;
	margin: 0 0 20px 0;
	padding:10px;
	background: #dedede;
}

/* Top area - instructions */
.customise_editpanel_instructions {
	width:690px;
	padding:0 0 10px 0;
}
.customise_editpanel_instructions h2 {
	padding:0 0 10px 0;
}
.customise_editpanel_instructions p {
	margin:0 0 5px 0;
	line-height: 1.4em;
}

/* RHS (widget gallery area) */
#customise_editpanel_rhs {
	float:right;
	width:230px;
	background:white;
}
#customise_editpanel #customise_editpanel_rhs h2 {
	color:#333333;
	font-size: 1.4em;
	margin:0;
	padding:6px;
}
#widget_picker_gallery {
	border-top:1px solid #cccccc;
	background:white;
	width:210px; 
	height:340px;
	padding:10px;
	overflow:scroll;
	overflow-x:hidden;
}

#customise_page_view {/* main page widget area */

	width:656px;
	padding:10px;
	margin:0 0 10px 0;
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
}
#customise_page_view h2 {
	border-top:1px solid #cccccc;
	border-right:1px solid #cccccc;
	border-left:1px solid #cccccc;
	margin:0;
	padding:5px;
	width:200px;
	color: #333;
	background: #dedede;
	font-size:1.25em;
	line-height: 1.2em;
}
#profile_box_widgets {
	width:422px;
	margin:0 10px 10px 0;
	padding:5px 5px 0px 5px;
	min-height: 50px;
	border:1px solid #cccccc;
	background: #dedede;
}
#customise_page_view h2.profile_box {
	width:422px;
	color: #999999;
}
#profile_box_widgets p {
	color:#999999;
}
#leftcolumn_widgets {
	width:200px;
	margin:0 10px 0 0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#middlecolumn_widgets {
	width:200px;
	margin:0 10px 0 0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#rightcolumn_widgets {
	width:200px;
	margin:0;
	padding:5px 5px 40px 5px;
	min-height: 190px;
	border:1px solid #cccccc;
}
#rightcolumn_widgets.long {
	min-height: 288px;
}
/* IE6 fix */
* html #leftcolumn_widgets { 
	height: 190px;
}
* html #middlecolumn_widgets { 
	height: 190px;
}
* html #rightcolumn_widgets { 
	height: 190px;
}
* html #rightcolumn_widgets.long { 
	height: 338px;
}

#customise_editpanel table.draggable_widget {
	width:200px;
	background: #cccccc;
	margin: 10px 0 0 0;
	vertical-align:text-top;
	border:1px solid #cccccc;
}
#widget_picker_gallery table.draggable_widget {
	width:200px;
	background: #cccccc;
	margin: 10px 0 0 0;
}

/* take care of long widget names */
#customise_editpanel table.draggable_widget h3 {
	word-wrap:break-word;/* safari, webkit, ie */
	width:140px;
	line-height: 1.1em;
	overflow: hidden;/* ff */
	padding:4px;
}
#widget_picker_gallery table.draggable_widget h3 {
	word-wrap:break-word;
	width:145px;
	line-height: 1.1em;
	overflow: hidden;
	padding:4px;
}
#customise_editpanel img.more_info {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_customise_info.gif) no-repeat top left;
	cursor:pointer;
}
#customise_editpanel img.drag_handle {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_customise_drag.gif) no-repeat top left;
	cursor:move;
}
#customise_editpanel img {
	margin-top:4px;
}
#widget_moreinfo {
	position:absolute;
	border:1px solid #333333;
	background:#e4ecf5;
	color:#333333;
	padding:5px;
	display:none;
	width: 200px;
	line-height: 1.2em;
}
/* droppable area hover class  */
.droppable-hover {
	background:#c5e3ff;
}
/* target drop area class */
.placeholder {
	border:2px dashed #AAA;
	width:196px !important;
	margin: 10px 0 10px 0;
}
/* class of widget while dragging */
.ui-sortable-helper {
	background: #2779e7;
	color:white;
	padding: 4px;
	margin: 10px 0 0 0;
	width:200px;
}
/* IE6 fix */
* html .placeholder { 
	margin: 0;
}
/* IE7 */
*:first-child+html .placeholder {
	margin: 0;
}
/* IE6 fix */
* html .ui-sortable-helper h3 { 
	padding: 4px;
}
* html .ui-sortable-helper img.drag_handle, * html .ui-sortable-helper img.remove_me, * html .ui-sortable-helper img.more_info {
	padding-top: 4px;
}
/* IE7 */
*:first-child+html .ui-sortable-helper h3 {
	padding: 4px;
}
*:first-child+html .ui-sortable-helper img.drag_handle, *:first-child+html .ui-sortable-helper img.remove_me, *:first-child+html .ui-sortable-helper img.more_info {
	padding-top: 4px;
}


/* ***************************************
	BREADCRUMBS
*************************************** */
#pages_breadcrumbs {
	font-size: 80%;
	color:#333333;
	padding:0;
	margin:2px 0 0 10px;
}
#pages_breadcrumbs a {
	color:#118908;
	text-decoration: none;
}
#pages_breadcrumbs a:hover {
	text-decoration: underline;
}


/* ***************************************
	MISC.
*************************************** */
/* general page titles in main content area */
#content_area_user_title{
  background: transparent;
  margin:10px;
  padding-bottom:5px;
  border-bottom:2px solid #2779e7;

}
#content_area_user_title h2 {	
color:#FFFFFF;
font-size:14px;
line-height:16px;
color:#2779e7;
font-weight:bold;
font-size:14px;
}
/* reusable generic collapsible box */
.collapsible_box {
	background:#dedede;
	padding:5px 10px 5px 10px;
	margin:4px 0 4px 0;
	display:none;
}	
a.collapsibleboxlink {
	cursor:pointer;
}

/* tag icon */	
.object_tag_string {
	background: url(<?php echo $vars['url']; ?>mod/socializeme/graphics/icon_tag.gif) no-repeat left 2px;
	padding:0 0 0 14px;
	margin:0;
}	

/* profile picture upload n crop page */	
#profile_picture_form {
	height:145px;
}	
#current_user_avatar {
	float:left;
	width:160px;
	height:130px;
	border-right:1px solid #cccccc;
	margin:0 20px 0 0;
}	
#profile_picture_croppingtool {
	border-top: 1px solid #cccccc;
	margin:20px 0 0 0;
	padding:10px 0 0 0;
}	
#profile_picture_croppingtool #user_avatar {
	float: left;
	margin-right: 20px;
}	
#profile_picture_croppingtool #applycropping {

}
#profile_picture_croppingtool #user_avatar_preview {
	float: left;
	position: relative;
	overflow: hidden;
	width: 100px;
	height: 100px;
}	


/* ***************************************
	SETTINGS & ADMIN
*************************************** */
.admin_statistics,
.admin_users_online,
.usersettings_statistics,
.admin_adduser_link,
#add-box,
#search-box,
#logbrowser_search_area {
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
	background:white;
	margin:0 10px 10px 10px;
	padding:10px;
}

.usersettings_statistics h3,
.admin_statistics h3,
.admin_users_online h3,
.user_settings h3,
.notification_methods h3 {
	background:#e4e4e4;
	color:#333333;
	font-size:1.1em;
	line-height:1em;
	margin:0 0 10px 0;
	padding:5px;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;	
}
h3.settings {
	background:#e4e4e4;
	color:#333333;
	font-size:1.1em;
	line-height:1em;
	margin:10px 0 4px 0;
	padding:5px;
}
.admin_users_online .profile_status {
	background:#8ce08c;
	line-height:1.2em;
	padding:2px 4px;
}
.admin_users_online .profile_status span {
	font-size:90%;
	color:#666666;
}
.admin_users_online  p.owner_timestamp {
	padding-left:3px;
}


.admin_debug label,
.admin_usage label {
	color:#333333;
	font-size:100%;
	font-weight:normal;
}

.admin_usage {
	border-bottom:1px solid #cccccc;
	padding:0 0 20px 0;
}
.usersettings_statistics .odd,
.admin_statistics .odd {

}
.usersettings_statistics .even,
.admin_statistics .even {

}
.usersettings_statistics td,
.admin_statistics td {
	padding:2px 4px 2px 4px;
	border-bottom:1px solid #cccccc;
}
.usersettings_statistics td.column_one,
.admin_statistics td.column_one {
	width:200px;
}
.usersettings_statistics table,
.admin_statistics table {
	width:100%;
}
.usersettings_statistics table,
.admin_statistics table {
	border-top:1px solid #cccccc;
}
.usersettings_statistics table tr:hover,
.admin_statistics table tr:hover {
	background: #E4E4E4;
}
.admin_users_online .search_listing {
	margin:0 0 5px 0;
	padding:5px;
	border:2px solid #cccccc;
}



/* force tinyMCE editor initial width for safari */
.mceLayout {
	width:683px;
}
p.longtext_editarea {
	margin:0 !important;
}
.toggle_editor_container {
	margin:0 0 15px 0;
}
/* add/remove longtext tinyMCE editor */
a.toggle_editor {
	display:block;
	float:right;
	text-align:right;
	color:#666666;
	font-size:1em;
	font-weight:normal;
}

div.ajax_loader {
	background: white url(<?php echo $vars['url']; ?>mod/socializeme/graphics/ajax_loader_bw.gif) no-repeat center 30px;
	width:auto;
	height:100px;
	margin:0 10px 0 10px;
}



/* reusable elgg horizontal tabbed navigation 
   (used on friends collections, external pages, & riverdashboard mods)
*/
#elgg_horizontal_tabbed_nav {
	margin:0 0 5px 0;
	padding: 0;
	border-bottom: 1px solid #cccccc;
	display:table;
	width:100%;
}
#elgg_horizontal_tabbed_nav ul {
	list-style: none;
	padding: 0;
	margin: 0;
}
#elgg_horizontal_tabbed_nav li {
	float: left;
	border: 1px solid #cccccc;
	border-bottom-width: 0;
	background: #eeeeee;
	margin: 0 0 0 10px;

}
#elgg_horizontal_tabbed_nav a {
	text-decoration: none;
	display: block;
	padding:3px 10px 0 10px;
	color: #999999;
	text-align: center;
	height:21px;
}
/* IE6 fix */
* html #elgg_horizontal_tabbed_nav a { display: inline; }

#elgg_horizontal_tabbed_nav a:hover {
	color: #fff;
	background: #2779e7;
}
#elgg_horizontal_tabbed_nav .selected {
	border-color: #cccccc;
	background: transparent;
}
#elgg_horizontal_tabbed_nav .selected a {
	position: relative;
	top: 2px;
	background: #f5f5f5;
	color: #2779e7;
}
/* IE6 fix */
* html #elgg_horizontal_tabbed_nav .selected a { top: 3px; }


/* ***************************************
	ADMIN AREA - REPORTED CONTENT
*************************************** */
.reportedcontent_content {
	margin:0 0 5px 0;
	padding:0 7px 4px 10px;
}
.reportedcontent_content p.reportedcontent_detail,
.reportedcontent_content p {
	margin:0;
}
.active_report {
	border:1px solid #D3322A;
    background:#F7DAD8;
}
.archived_report {
	border:1px solid #666666;
    background:#dedede;
}
a.archive_report_button {
	float:right;
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#2779e7;
	border: 1px solid #2779e7;
	width: auto;
	padding: 4px;
	margin:15px 0 0 20px;
	cursor: pointer;
}
a.archive_report_button:hover {
	background: #2779e7;
	border: 1px solid #333;
	text-decoration: none;
}
a.delete_report_button {
	float:right;
	font: 12px/100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #ffffff;
	background:#999999;
	border: 1px solid #999999;
	width: auto;
	padding: 4px;
	margin:15px 0 0 20px;
	cursor: pointer;
}
a.delete_report_button:hover {
	background: #333333;
	border: 1px solid #333333;
	text-decoration:none;
}
.reportedcontent_content .collapsible_box {
	background: white;
}


/* ***************************************
	Custom Navigation Bar 
*************************************** */
#navigation-bar{
  float:right;
  height:30px;
  margin-right:25px;
  width:730px;
  clear:right;
}
li.navlist {
  display:inline;
  float:left;
  padding-right:22px;
}
a.home-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/home.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.home-icon{
  display:block;
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/home.png) no-repeat;
  height:75px;
  width:62px;
}

a.signup-icon:hover{
  display:block;
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/register.png) no-repeat left -75px;
  height:75px;
  width:62px;
}
a.signup-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/register.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}

a.myprofile-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/profile.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.myprofile-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/profile.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}
a.dashboard-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/dashboard.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:92px;
}
a.dashboard-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/dashboard.png) no-repeat;
  display:block;
  height:75px;
  width:92px;
}
a.mail-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/mailbox.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.mail-icon{
  display:block;
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/mailbox.png) no-repeat;
  height:75px;
  width:62px;
}
a.settings-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/settings.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.settings-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/settings.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}
a.friends-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/friends.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.friends-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/friends.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}
a.groups-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/groups.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.groups-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/groups.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}
a.blogs-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/blogs.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.blogs-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/blogs.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}
a.files-icon:hover{
  background:transparent url(<?php echo $vars['url']; ?>mod/socializeme/graphics/files.png) no-repeat left -75px;
  display:block;
  height:75px;
  width:62px;
}
a.files-icon{
  background:url(<?php echo $vars['url']; ?>mod/socializeme/graphics/files.png) no-repeat;
  display:block;
  height:75px;
  width:62px;
}

/* ***************************************
	Custom Settings 
*************************************** */

#home-elgg_topbar_container_left {
float:left;
height:24px;
left:0;
position:absolute;
text-align:left;
top:0;
width:93%;
}
#site_logo{
width:200px;
height:70px;
float:left;
}

#site_intoback{
float:left;
}

#add_post_link a{
border-top:none;
	margin:inherit;
	color:#FFFFFF;
	padding:0 0 5px 5px;
	font-size:1.25em;
	line-height:1.2em;
	font-weight:bold;
}

/* ***************************************
	Top Menu Settings 
*************************************** */

 #tabs6 {
      float:right;
      margin-top:-10px;
      width:760px;
      font-size:93%;
            }
    #tabs6 ul {
          margin:0;
          padding:5px 5px 0 5px;
          list-style:none;
      }
    #tabs6 li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs6 a {
      float:right;
      background:#333;
      margin:0;
      padding:0 0 0 2px;
      text-decoration:none;
      }
    #tabs6 a span {
      float:left;
      display:block;
      padding:5px 5px 4px 6px;
      color:#FFF;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs6 a span {float:none;}
    /* End IE5-Mac hack */
    #tabs6 a:hover span {
      color:#FFF;
      }
    #tabs6 a:hover {
            background:#2779e7;

      }



/* CUSTOM */
#elgg_taskbar {
	position: fixed;
	bottom: 0px;
	height: 25px;
	left: 0px;
	z-index: 9999;
	background: #E1E1E1;
	margin: 0px 20px;
	border: 1px solid #969696;
	border-bottom: 0px;
	padding-bottom: 2px;
	-webkit-border-top-left-radius: 8px; 
	-webkit-border-top-right-radius: 8px; 
	-moz-border-radius-topleft: 8px;
	-moz-border-radius-topright: 8px;
}

#leftside_taskbar {
	float: left;
}

.p_t {
	border-bottom: 2px solid #FFD400;
	cursor: help;
}
.f_t {
	border-bottom: 2px solid #50D050;
	cursor: help;
}