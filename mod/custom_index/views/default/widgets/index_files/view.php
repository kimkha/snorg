<?php

	/**
	 * Widget in custom index
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 10;
	$files = list_entities('object','file',0,$limit,false, false, false);

    if (!empty($files)) {
        echo $files;//this will display files
    }else{
        echo "<p><?php echo elgg_echo('custom:nofiles'); ?></p>";
    }
    echo "<div class='clearfloat'></div>";
	
?>