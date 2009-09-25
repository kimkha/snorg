<?php

	/**
	 * Mutural friends
	 * 
	 * @author KimKha
	 * @package Snorg
	 */
	

    //the page owner
	$owner = get_user($vars['entity']->owner_guid);
	
	$visitor = $_SESSION['user']->getGUID();

    //the number of files to display
	$num = (int) $vars['entity']->num_display;
	if (!$num)
		$num = 8;
		
	//get the correct size
	$size = (int) $vars['entity']->icon_size;
	if (!$size || $size == 1){
		$size_value = "small";
	}else{
    	$size_value = "tiny";
	}
		
	$list = $owner->getFriends();
	shuffle($list);
	
	$mutural = array();
	$i = 0;
	foreach ($list as $friend) 
	{
		$i++;
		if ($i>$num) {
			break;
		}
		if ($friend->isFriendOf($visitor)) // This is a mutural friend 
		{
			$mutural[] = $friend;
		}
	}

	// If there are any $friend to view, view them
	if (sizeof($mutural) > 0 && $owner->guid != $visitor) {
		echo " <a id='btn_mf_show_all' href='javascript:viewFriendsBox(\"GetMutualFriends\", {$vars['entity']->owner_guid});' > " . ' ' . elgg_echo('friends:widget:showall')."</a>";
		echo "<div id=\"widget_friends_list\">";

		foreach($mutural as $friend) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => $size_value));
			echo "</div>";
		}

		echo "</div>";
			
    }
	
?>