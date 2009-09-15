<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	global $CONFIG;
	admin_gatekeeper();
	$id = (int) get_input("id");
	$entity = get_entity($id);
	
	if ($entity && $entity->getType() == "object" && $entity->getSubtype() == "image") {
		if ($entity->getAccessID() == ACCESS_PUBLIC) {
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