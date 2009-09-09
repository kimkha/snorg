<?php
	/**
	 * Comment on wall post
	 * 
	 * @author KimKha
	 */
	
	$entity = get_entity((int) get_input("id"));
	$content = get_input("content", '');
	if ($entity && $content != '') {
		
		if ($entity->annotate('generic_comment',$content,$entity->access_id, $_SESSION['guid'])) {
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
			
			//add to river
			add_to_river('annotation/annotate','comment',$_SESSION['user']->guid,$entity->guid);
			
			$new = $entity->getAnnotations('generic_comment',1,0,'desc');
			echo elgg_view_comment($new[0]);
		}
		
	}
	exit();
?>