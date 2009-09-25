<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$id = (int) get_input('id', 0);
	if ($id == 0) {
		register_error(elgg_echo("stick:user:emptyid"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	$entity = get_entity($id);
	
	$userId = $entity->owner_guid;
	$user = get_entity($userId);
	
	$title = "Edit commend ".$user->name;
	$header = elgg_view_title($title);
	
	$block = elgg_view_entity($user);
	
	$body = elgg_view("stick/forms/commend", array("userid" => $userId, 'entity' => $entity));
	
	$content = elgg_view_layout("two_column_left_sidebar", $block, $header.$body);
	
	page_draw($title,$content);
	exit();
?>