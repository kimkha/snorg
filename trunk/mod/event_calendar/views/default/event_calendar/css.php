<?php
//$background_colour = '#EBF1EB';
//$highlight_colour = '#478787';

$background_colour = '#F5F5F5';
$highlight_colour = '#3874B7';
?>

div#calendarmenucontainer {
	position: relative;
}

ul#calendarmenu {
	list-style: none;
	position: absolute;
	top: 0px;
	left: -15px;
}

ul#calendarmenu li {
	float: left;
	border-top: 1px solid #969696;
	border-left: 1px solid #969696;
	border-bottom: 1px solid #969696;
	background-color: <?php echo $background_colour; ?>;
}


ul#calendarmenu li.sys_calmenu_last {
	border-right: 1px solid #969696;
}

ul#calendarmenu li a {
	text-decoration: none;
	padding: 4px 12px;
	float: left;
}

ul#calendarmenu li a:hover, ul#calendarmenu li.sys_selected a{
	text-decoration: none;
	padding: 4px 12px;
	float: left;
	color: #FFFFFF;
	background: <?php echo $highlight_colour; ?>;
}


.river_object_event_calendar_create {
	background: url(<?php echo $vars['url']; ?>mod/event_calendar/images/river_icon_event.gif) no-repeat left -1px;
}
.river_object_event_calendar_update {
	background: url(<?php echo $vars['url']; ?>mod/event_calendar/images/river_icon_event.gif) no-repeat left -1px;
}
#event_list {
	width:440px;
	margin:0;
	float:left;
	padding:5px 0 0 0;
}
#event_list .search_listing {
	border:2px solid #cccccc;
	margin:0 0 5px 0;
}

.events {
	min-height: 300px;
}
