<?php
	
?>
.blograting {
	float: left;
	margin: 0px;
	padding: 2px 10px;
}
.blograting .point {
	float: left;
	display: inline-block;
}
.rating {
	cursor: pointer;
	float: left;
	display: inline-block;
}
.rating:after {
	content: '.';
	height: 0;
	width: 0;
	clear: both;
	visibility: hidden;
}
.rating .cancel,
.rating .star {
	float: left;
	width: 17px;
	height: 15px;
	overflow: hidden;
	text-indent: -999em;
	cursor: pointer;
}
.rating .star-left,
.rating .star-right {
  width: 8px
}
.rating .cancel,
.rating .cancel a {
	background: url(<?php echo $vars['url'].'_graphics/'?>delete.gif) no-repeat 0 -16px;
}

.rating .star,
.rating .star a {
	background: url(<?php echo $vars['url'].'_graphics/'?>star.gif) no-repeat 0 0px;
}
.rating .star-left,
.rating .star-left a {
	background: url(<?php echo $vars['url'].'_graphics/'?>star-left.gif) no-repeat 0 0px;
}
.rating .star-right,
.rating .star-right a {
	background: url(<?php echo $vars['url'].'_graphics/'?>star-right.gif) no-repeat 0 0px;
}
	
.rating .cancel a,
.rating .star a {
	display: block;
	width: 100%;
	height: 100%;
	background-position: 0 0px;
}

div.rating div.on a {
	background-position: 0 -16px;
}
div.rating div.hover a,
div.rating div a:hover {
	background-position: 0 -32px;
}


