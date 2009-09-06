<?php

	/**
	 * Demo content for tabs of profile
	 * 
	 * @author KimKha
	 * 
	 */
	
	$user = get_user(get_input("owner", 0));
	if (!$user) exit();
	
	$enable_subtype = json_decode(get_plugin_usersetting("subtypesWallpost", $user->getGUID()));
	$count = get_plugin_setting("countOfWallPost", "profile");
	$time = get_plugin_setting("timeOfWallPost", "profile");
	if (!$time) $time = 15; //days
	if (!$count) $count = 20; //posts
	$timelower = time() - ($time * 24 * 60 * 60);
	$list_obj = get_user_objects( $user->getGUID(),"", $count*2, 0, $timelower);
	
	echo "<div id='wallpost'>";
	
	if (is_array($list_obj) && sizeof($list_obj) > 0) {
		foreach ($list_obj as $entity) {
			$subtype = $entity->getSubtype();
			if (elgg_view_exists("object/{$subtype}")) {
				echo elgg_view("object/{$subtype}", array('entity' => $entity, 'full' => false, 'viewtype' => 'wall'));
				$count--;
			}
			if ($count<=0) break;
		}
	}
	
	echo "</div>";
	
?>