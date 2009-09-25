<?php

	/**
	 * Widget in custom index
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 4;
	$groups = list_entities('group','',0,$limit,false, false, false);
	
    if (!empty($groups)) {
        echo $groups;//this will display groups
    }else{
        echo "<p><?php echo elgg_echo('custom:nogroups'); ?>.</p>";
    }
    echo "<div class='clearfloat'></div>";
	
?>