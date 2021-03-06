<?php

	/**
	 * Mutural friends
	 * 
	 * @author KimKha
	 * @package Snorg
	 */
	

    //the page owner
	$owner = page_owner_entity();
	$visitor = get_loggedin_userid();

    //the number of files to display
		$num = 6;
		
	//get the correct size
    	$size_value = "small";
		
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
		echo "<div id='muturalfriends-leftbar' class='collapsable_box'>";
		echo "<div class='collapsable_box_header'>";
		echo '<a class="toggle_box_contents" href="javascript:void(0);">-</a>';
		echo " <div class='leftbar_show_all' onclick='javascript:viewFriendsBox(\"GetMutualFriends\", {$owner->guid}, \"Mutural friends\");' > " . elgg_echo('friends:widget:showall')."</div>";
		echo '<h1>'.elgg_echo("friends:mutural").'</h1>';
		echo "<div class='clearfloat'></div></div>";
		
		echo '<div class="collapsable_box_content">';
		
		
		echo "<div id=\"list\">";

		foreach($mutural as $friend) {
			echo "<div class=\"singlefriend\" >";
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => $size_value));
			echo "</div>";
		}

		echo "<div class='clearfloat'></div></div>";
			
	    echo "</div></div>";
			
    }
    echo " ";
	
?>