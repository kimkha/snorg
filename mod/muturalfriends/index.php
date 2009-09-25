<?php

	/**
	 * Mutural friends
	 * 
	 * @author KimKha
	 * @package Snorg
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
	
	gatekeeper();
	
	$page_owner = page_owner_entity();
	
	$area1 = elgg_view_title(elgg_echo('friends:mutural:between').$page_owner->username);
	$area2 = elgg_view('muturalfriends/view');
	
	// Format page
	$body = elgg_view_layout('two_column_left_sidebar','', $area1.$area2);

	echo page_draw(elgg_echo('friends:mutural'),$body);
	
?>