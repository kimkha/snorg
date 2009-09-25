<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$id = (int) get_input('id');
	$entity = get_entity($id);
	$user = $entity->getOwnerEntity();
	
	if ($entity->delete()) {
		remove_metadata($user->guid, 'stick:user:all');
		create_metadata($user->guid, 'stick:user:all', stick_cv_commends($user->guid), 'text', $entity->guid, ACCESS_PUBLIC);
		
		system_message(elgg_echo("stick:user:removesuccessful"));
		forward("pg/profile/".$user->username);
	} else {
		register_error(elgg_echo("stick:user:removeerror"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
?>