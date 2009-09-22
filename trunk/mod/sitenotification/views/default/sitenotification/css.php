<?php


?>

#notification_taskbar {
	float: left;
	border-right: 1px solid #000000;
	padding: 0px 5px;
	margin: 2px 0;
	height: 21px;
}

#notification_wrapper {
	display: none;
}

#notification_data {
	border: 1px solid #4690D6;
	border-bottom: 0px;
	background: #E4ECF5;
	
	-moz-border-radius-topright:5px; 
	-moz-border-radius-topleft:5px; 
	-webkit-border-top-left-radius:5px;
	-webkit-border-top-right-radius:5px;
	margin: 0 -4px;
	position:absolute;
	bottom:27px;
	width:236px;
	overflow:hidden;
}

#notification_data .showall {
	float: right;
	margin: 0px 5px;
}

#notification_content {
	max-height: 350px !important;
	overflow: auto;
	border-top: 1px dashed #2779E7;
}

#notification_content .loading {
	display: none;
}
