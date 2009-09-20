<?php
	/**
	 * Tidypics Add Photo Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();
	
	$user = $_SESSION['user'];
	$user_id = get_input('user_id');
	$friend = get_user($user_id);
	$image_guid = get_input('image_guid');
	
	
	if ($image_guid == 0) {
		register_error(elgg_echo("tidypics:phototagging:error"));
		forward($_SERVER['HTTP_REFERER']);
	}

	$image = get_entity($image_guid);
	
	if (!$image)
	{
		register_error(elgg_echo("tidypics:phototagging:error"));
		forward($_SERVER['HTTP_REFERER']);
	}

	// test for empty tag
	if ($user_id == 0 ) {
		register_error(elgg_echo("tidypics:phototagging:error"));
		forward($_SERVER['HTTP_REFERER']);
	}



	
	//Save annotation
	if ($image->annotate('taguser', $friend, null,$user_id )) {

	   system_message(elgg_echo('taguser:sysnotify:sucessful'));
	}
	else 
	{
		 system_message(elgg_echo('taguser:sysnotify:fail'));
		
	}


	forward($_SERVER['HTTP_REFERER']);

?>
