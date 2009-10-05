<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$userId = (int) get_input('userid');
	$user = get_entity($userId);
	
	$title = sprintf(elgg_echo('stick:user:add'), $user->name);
	$header = elgg_view_title($title);
	
	$block = elgg_view_entity($user);
	
	$body = elgg_view("stick/forms/commend", array("userid" => $userId));
	
	$content = elgg_view_layout("two_column_left_sidebar", $block, $header.$body);
	
	page_draw($title,$content);
	exit();
?>