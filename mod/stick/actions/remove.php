<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	admin_gatekeeper();
	
	$id = (int) get_input("id");
	
	if (delete_relationship($id)){
		system_message(elgg_echo("stick:removesuccessful"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	register_error(elgg_echo("stick:removeerror"));
	forward($_SERVER['HTTP_REFERER']);
	
?>