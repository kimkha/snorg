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
					notify_user($entity->owner_guid, $_SESSION['user']->getGUID(),"comment on topic",$entity->title."-".$entity->getURL());
					
				// snorg - bkit06 - get user who is commented in this topic	
					$comments = $entity->getAnnotations('generic_comment');
					$otherUser = array();
					foreach ($comments as $comment) {
						$otherUser[] = $comment->owner_guid;
					}
					//	echo "<pre>"; print_r($otherUser);	
						//	echo "<pre>"; print_r("-----------");	
				
					
					$otherUser = array_unique($otherUser);
							
							//	echo "<pre>"; print_r($otherUser);	
					//echo "<pre>"; print_r("-----------");	
					
					$lastUser = $_SESSION['user'];
					
					$int = array_search($_SESSION['user']->getGUID(),$otherUser);
					if (is_numeric($int))
						unset($otherUser[$int]);
					//echo "<pre>"; print_r($otherUser);	
				//	echo "<pre>"; print_r("-----------");
					
								
					$int = array_search($entity->owner_guid,$otherUser);
					if (is_numeric($int))
						unset($otherUser[$int]);
				//	echo "<pre>"; print_r($otherUser); die;
					
				//	echo "<pre>"; print_r($otherUser); die;
						// snorg - bkit06 - send notify to person who is comment on this topic
				
						
					
						// snorg - bkit06 - send notify to person who is tagged in photo
					$friends = get_entities_from_relationship('phototag', $entity->getGUID(), true , user , '', 0, 'time_created desc', 1000);
					if ($friends) {
							foreach($friends as $friend) {
								$friend_array[] = $friend->getGUID();
							}
							
						$int = array_search($_SESSION['user']->getGUID(),$friend_array);
						if (is_numeric($int))
						{
								unset($friend_array[$int]);	
						}
						
						
							foreach($friend_array as $uid)
							{
								$int = array_search($uid,$otherUser);
								if (is_numeric($int))
									unset($otherUser[$int]);
									
								if ($uid != $entity->owner_guid )
									notify_user($uid, $lastUser->getGUID(), " Commented on photo ",$entity->title."-".$entity->getURL());
							}
							
							
					}
					
					
					foreach ($otherUser as $uid) {
											
						notify_user($uid, $lastUser->getGUID(), "also comment on topic",$entity->title."-".$entity->getURL());
						
					}	
						//echo "<pre>"; print_r($otherUser); die;


				//	system_message(elgg_echo("generic_comment:posted"));
					//add to river
					add_to_river('annotation/annotate','comment',$_SESSION['user']->guid,$entity->guid);
			
			$new = $entity->getAnnotations('generic_comment',1,0,'desc');
			echo elgg_view_comment($new[0]);
		}
		
	}
	exit();
?>