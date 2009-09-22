<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	global $CONFIG;
	
	$list = get_entities("object", _STICK_COMMEND_SUBTYPE_, 0, "", 20);
	
	$i = 1;
	foreach ($list as $item) {
		// get icon to view
		$user = $item->getOwnerEntity();
		$icon = elgg_view("profile/icon", array(
										'entity' => $user,
										'size' => 'small',
									  )
		);
		
		// get info
		$info = "<p><b><a href=\"" . $user->getUrl() . "\" rel=\"$rel\">" . $user->name . "</a></b></p>";
		
		$time = $item->time_created;
		$time = friendly_time($time);
		$info .= "<div class='stick-comment-time'>" . $time ."</div>";
		
		$info .= "<div class='stick-commend-details'>";
		$info .= "<h3><a href=\"" . $CONFIG->wwwroot . "pg/stick/commend?id=" . $item->guid . "\" rel=\"$rel\">" . $item->title . "</a></h3>";
		$info .= split_html($item->description, 300);
		$info .= "</div>";
		
		// view item
		echo elgg_view_listing($icon, $info);
		$i++;
	}
	echo " ";
	
?>