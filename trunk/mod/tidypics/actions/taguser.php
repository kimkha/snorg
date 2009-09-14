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
	
//	echo "<pre>"; print_r($friend); die;
	
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
	// if tag is a user id, add relationship for searching (find all images with user x
	$friends = $image->getAnnotations('taguser');
	//	echo "<pre>"; print_r($friends); die;
	   system_message("okie");
	  // $friends = $image->getAnnotations('taguser');
	   //echo "<pre>"; print_r($friends); die;
				
				// also add this to the river
			

    
    // Snorg - Bkit06
				
	//else
	//	register_error("can not send a Notify");
	
		
		system_message(elgg_echo("tidypics:phototagging:success"));
	}


	forward($_SERVER['HTTP_REFERER']);

?>
