<?php

/**
* Taguser
* Taguser into a entity
* 
* @author BKIT06
* @package SNORG
*/
	// Ensure we're logged in
		if (!isloggedin()) forward();
		
	// Make sure we can get the comment in question
		$annotation_id = (int) get_input('annotation_id');
		if ($comment = get_annotation($annotation_id)) {
    		
    		$entity = get_entity($comment->entity_guid);
			
			if ($comment->canEdit()) {
				$comment->delete();
				system_message(elgg_echo("taguser:untag"));
				forward($entity->getURL());
			}
			
		} else {
			$url = "";
		}
		
		register_error(elgg_echo("taguser:notuntag"));
		forward($entity->getURL());

?>