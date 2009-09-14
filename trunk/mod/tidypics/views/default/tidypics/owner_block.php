
<?php

	$photo_tags = $vars['photo_tags'];
	$links = $vars['links'];
	$photo_tags_json = $vars['photo_tags_json'];
	$file_guid = $vars['file_guid'];
//	$viewer = $vars['viewer'];
//	$owner = $vars['owner'];

	//echo "<pre>"; print_r($file_guid); die;
	

	$viewer = get_loggedin_user();
	$entity_guid =  $vars['entity'];
	$entity = get_entity($entity_guid);
	$owner = get_entity($entity->owner_guid);
//	echo "<pre>"; print_r($entity); die;
	
//	echo $viewer->name();

	echo elgg_view('js/tag');
	
	if($viewer == $owner) {
		$friends = get_entities_from_relationship('friend', $viewer->getGUID(), false, 'user', '', 0, 'time_created desc', 1000);
		
		if ($friends) {
			foreach($friends as $friend) {
				$friend_array[$friend->name] = $friend->getGUID();
			}
		}
		ksort($friend_array);

		$content = "<input type='hidden' name='image_guid' value='{$entity_guid}' />";
		$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
			
		$content .= "<ul id='tidypics_phototag_list'>";
		$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($friends) {
			foreach($friend_array as $friend_name => $friend_guid) {
				$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$friend_guid}, \"{$friend_name}\")'>{$friend_name}</a></li>";
			}
		}
		
			$content .= "</ul>";

	$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiontag') . "' class='submit_button' />";
	
	//echo "hoai";
	
	
	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'tidypics_phototag_form', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/taguser", 'body' => $content));
	}

	


	
	
   if( $entity->getAnnotations('taguser'))
   {
   	 $friends = $entity->getAnnotations('taguser');
   	 
  	// echo "<pre>"; print_r($friends); die;
  	
   	 $otherUser = array();
   	 
	 foreach ($friends as $friend) {
						$otherUser[] = $friend->owner_guid;
											
		}
		
		$otherUser = array_unique($otherUser);
	
		echo "Who tagged In: <br>";
		echo "<div id=\"widget_friends_list\">";
		
		foreach($otherUser as $taggeduser) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($taggeduser), 'size' => 'small'));
			//echo get_user($taggeduser);
		//	echo "<a onclick=delete_annotation({$taggeduser})'>DELETE</a>"
			echo "</div>";
		}

		echo "</div>";
		echo "<br";
		
	
   	 
   	 echo $friends;
   	 system_message("hoai");
   }
		//echo $friends->name();
		//echo "<pre>"; print_r($friends); die;
	

?>