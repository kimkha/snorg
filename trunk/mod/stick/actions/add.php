<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	admin_gatekeeper();
	
	$id = (int) get_input("id");
	$category = get_input("category");
	$entity = get_entity($id);
	
	if ($entity && $entity->getType() == "object" ) {
		if ($entity->getAccessID() == ACCESS_PUBLIC) {
			if (add_entity_relationship(1, _STICK_BLOG_RELATIONSHIP_.$category, $id)) {
				system_message(elgg_echo("stick:successful"));
				forward();
			}
			else {
				register_error(elgg_echo("stick:error"));
			}
		}
		else {
			register_error(elgg_echo("stick:notpublic"));
		}
	}
	else {
		register_error(elgg_echo("stick:error"));
	}
	
	forward($_SERVER['HTTP_REFERER']);
	
?>