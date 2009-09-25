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
		system_message(elgg_echo("stick:iremovesuccessful"));
	}
	else {
		register_error(elgg_echo("stick:iremoveerror"));
	}
	
	forward($_SERVER['HTTP_REFERER']);
	
?>