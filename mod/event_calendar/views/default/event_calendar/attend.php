<?php

	/**
	 * Show list attender in Event View
	 * Author: Bkit06 
	 * Snorg
	 * 2009	
	 */

	$event_guid = $vars['entity']->guid;
	 
	$attender = get_entities_from_relationship('eventattend',$event_guid,false,'user');
	
	if (is_array($attender) && sizeof($attender) > 0) {
		echo "<div class='contentWrapper'>";
		
		echo "<b>Confirm Guest: </b>";
		
		echo "<a href='javascript:viewFriendsBox(\"calendar&relationship=eventattend\", {$event_guid}, \"Attend\");' >" . elgg_echo('friends:widget:showall')."</a>";
		
		
		echo "<div id=\"widget_friends_list\">";
		
		foreach($attender as $friend) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => 'small'));
			echo "</div>";
		}

		echo "</div>";
		echo "</div>";
			
    }

	 
	 
 ?>