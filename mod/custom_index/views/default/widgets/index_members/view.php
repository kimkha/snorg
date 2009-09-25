<?php
	/**
	 * Widget in custom index
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 10;
	$newest_members = get_entities_from_metadata('icontime', '', 'user', '', 0, $limit);
	$newest_members = get_entities('user','',0,'',$limit);
	
    foreach($newest_members as $members){
        echo "<div class=\"index_member_item\">";
        echo elgg_view("profile/icon",array('entity' => $members, 'size' => 'small'));
        echo "</div>";
    }
    echo "<div class='clearfloat'></div>";
	
?>