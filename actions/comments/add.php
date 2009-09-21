<?php

	/**
	 * Elgg add comment action
	 * 
	 * @package Elgg
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <curverider.co.uk>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

	// Make sure we're logged in; forward to the front page if not
		gatekeeper();
		action_gatekeeper();
		
	// Get input
		$entity_guid = (int) get_input('entity_guid');
		$comment_text = get_input('generic_comment');
		
	// Let's see if we can get an entity with the specified GUID
		if ($entity = get_entity($entity_guid)) {
			
	        // If posting the comment was successful, say so
				if ($entity->annotate('generic_comment',$comment_text,$entity->access_id, $_SESSION['guid'])) {
					
					if ($entity->owner_guid != $_SESSION['user']->getGUID())
					notify_user($entity->owner_guid, $_SESSION['user']->getGUID(),"comment on"," topic"."-".$entity->getURL());
					
					
					$comments = $entity->getAnnotations('generic_comment');
					$otherUser = array();
					foreach ($comments as $comment) {
						$otherUser[] = $comment->owner_guid;
					}
					
					
					$otherUser = array_unique($otherUser);
								
					
					$lastUser = $_SESSION['user'];
					
					
					unset($otherUser[array_search($_SESSION['user']->getGUID(),$otherUser)]);
					unset($otherUser[array_search($entity->owner_guid,$otherUser)]);
					
					foreach ($otherUser as $uid) {
											
						notify_user($uid, $lastUser->getGUID(), "also comment on","  topic"."-".$entity->getURL());
						
					}
					
					
						// snorg - bkit06 - send notify to person who is tagged in photo
					$friends = get_entities_from_relationship('phototag', $entity->getGUID(), true , user , '', 0, 'time_created desc', 1000);
					if ($friends) {
							foreach($friends as $friend) {
								$friend_array[] = $friend->getGUID();
							}
						
							foreach($friend_array as $uid)
							{
								unset($otherUser[array_search($uid,$otherUser)]);
								notify_user($uid, $lastUser->getGUID(), " Commented on a Photo has you at","  here -".$entity->getURL());
							}
							
							
					}
	


					system_message(elgg_echo("generic_comment:posted"));
					//add to river
					add_to_river('annotation/annotate','comment',$_SESSION['user']->guid,$entity->guid);

					
				} else {
					register_error(elgg_echo("generic_comment:failure"));
				}
				
		} else {
		
			register_error(elgg_echo("generic_comment:notfound"));
			
		}
		
	// Forward to the 
		forward($_SERVER['HTTP_REFERER']);

?>