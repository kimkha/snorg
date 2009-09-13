<?php

	/**
	 * Demo content for tabs of profile
	 * 
	 * @author KimKha
	 * 
	 */
	
	$user = get_user(get_input("owner", 0));
	if (!$user) exit();
	
	$enable_subtype = get_wallpost_object($user->guid);
	
	$count = get_plugin_setting("countOfWallPost", "profile");
	if (!$count) $count = 20; //posts
	$time = get_plugin_setting("timeOfWallPost", "profile");
	if (!$time) $time = 15; //days
	
	// Get object
	$timelower = time() - ($time * 24 * 60 * 60);
	$list_obj = get_user_objects($user->getGUID(), $enable_subtype, $count, 0, $timelower);
	
	echo "<div id='wallpost'>";
	
	if (is_array($list_obj) && sizeof($list_obj) > 0) {
		foreach ($list_obj as $entity) {
			$subtype = $entity->getSubtype();
			echo view_wallpost($subtype, array('entity'=>$entity, 'viewtype'=>'wall'));
		}
	}
	else {
		echo "<i>There is no wall post</i>";
	}
	
	echo "</div>";
	
?>