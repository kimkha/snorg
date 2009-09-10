<?php

	/**
	 * Show list attender in Event View
	 * Author: Bkit06 
	 * Snorg
	 * 2009	
	 */

	$event_guid = $vars['entity']->guid;
	 
	$attender = get_entities_from_relationship('eventrequest',$event_guid,false,'user',null,null,null,3);
	
	if (is_array($attender) && sizeof($attender) > 0) {
		
		echo "<b>Not Confirm Guest:</b><br>";
		
		echo "<a id='btn_show_all' href='javascript:viewFriendsBox(\"GetFriends\", {$vars['entity']->owner_guid});' >" . elgg_echo('friends:widget:showall')."</a>";
		
		
		echo "<div id=\"widget_friends_list\">";
		
		foreach($attender as $friend) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => 'small'));
			echo "</div>";
		}

		echo "</div>";
		echo "<br";
		
			
    }

$attender = get_entities_from_relationship('eventmaybeattend',$event_guid,false,'user',null,null,null,3);
	
	if (is_array($attender) && sizeof($attender) > 0) {
		
		echo "<b>Maybe Attend:</b><br>";
		
		echo "<a id='btn_show_all' href='javascript:viewFriendsBox(\"GetFriends\", {$vars['entity']->owner_guid});' >" . elgg_echo('friends:widget:showall')."</a>";
		
		
		echo "<div id=\"widget_friends_list\">";
		
		foreach($attender as $friend) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => 'small'));
			echo "</div>";
		}

		echo "</div>";
		echo "<br";
		
			
    }
	 
	 
 ?>