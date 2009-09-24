<?php

    /**
	 * Elgg Friends
	 * Friend widget options
	 * 
	 * @package ElggFriends
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	
    //the page owner
	$owner = page_owner_entity();

    //the number of files to display
		$num = 20;
		
	//get the correct size
    	$size_value = "small";
		
    // Get the users friends
	$friends = $owner->getFriends("", $num, $offset = 0);
	
	// If there are any $friend to view, view them
	if (is_array($friends) && sizeof($friends) > 0) {
		echo "<div id='friends-leftbar' class='collapsable_box'>";
		echo "<div class='collapsable_box_header'>";
		echo '<a class="toggle_box_contents" href="javascript:void(0);">-</a>';
		echo "<div class='leftbar_show_all' onclick='viewFriendsBox(\"GetFriends\", {$owner->guid});' >" . elgg_echo('friends:widget:showall')."</div>";
		echo '<h1>'.elgg_echo("friends").'</h1>';
		echo "<div class='clearfloat'></div></div>";
		
		echo '<div class="collapsable_box_content">';
		
		echo "<div id=\"list\">";
		
		foreach($friends as $friend) {
			echo "<div class=\"singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => $size_value));
			echo "</div>";
		}

		echo "<div class='clearfloat'></div></div>";
			
	    echo "</div></div>";
    }
    echo " ";
	
?>