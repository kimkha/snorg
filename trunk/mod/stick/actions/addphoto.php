<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	global $CONFIG;
	admin_gatekeeper();
	$id = (int) get_input("id");
	$photo = get_entity($id);
	
	if ($photo && $photo->getType() == "object" && $photo->getSubtype() == "image") {
		$album = get_entity($photo->container_guid);
		if ($album->access_id == ACCESS_PUBLIC) {
			if (add_entity_relationship(1, _STICK_PHOTO_RELATIONSHIP_, $id)) {
				system_message(elgg_echo("stick:isuccessful"));
				forward("pg/stick/album");
			}
			else {
				register_error(elgg_echo("stick:ierror"));
			}
		}
		else {
			register_error(elgg_echo("stick:inotpublic"));
		}
	}
	else {
		register_error(elgg_echo("stick:ierror"));
	}
	
	forward($_SERVER['HTTP_REFERER']);
	
?>