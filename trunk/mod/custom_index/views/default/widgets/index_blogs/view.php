<?php

	/**
	 * Widget in custom index
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 4;
	$blogs = list_entities('object','blog',0,$limit,false, false, false);
	
	if(is_plugin_enabled('blog')){
		echo $blogs;
	}
	echo "<div class='clearfloat'></div>";
?>