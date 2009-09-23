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
		$num = 8;
		
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
		echo '<h1>'.elgg_echo("muturalfriends").'</h1>';
		echo "</div>";
		
		echo '<div class="collapsable_box_content">';
		
		
		echo " <a id='btn_mf_show_all' href='javascript:viewFriendsBox(\"GetMutualFriends\", {$owner->guid});' > " . elgg_echo('friends:widget:showall')."</a>";
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