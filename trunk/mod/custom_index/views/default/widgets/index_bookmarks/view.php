<?php

	/**
	 * Widget in custom index
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 4;
	$bookmarks = list_entities('object','bookmarks',0,$limit,false, false, false);
	
    if (isset($bookmarks)) 
        echo $bookmarks; //display bookmarks
	echo "<div class='clearfloat'></div>";
?>