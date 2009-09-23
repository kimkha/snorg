<?php
	/**
	 * Tidypics Add Photo Tag
	 * 
	 */

	gatekeeper();
	action_gatekeeper();
	
	//$user = $_SESSION['user'];
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



	// can check them truong hop da duoc add roi.
	//Save annotation
	
	
	$annotations = $image->getAnnotations('taguser',1000);
	foreach ($annotations as $annotation )
	{
		if ( $annotation->owner_guid == $user_id)
		{
			system_message(elgg_echo('taguser:sysnotify:exits'));
			forward($_SERVER['HTTP_REFERER']);
		}
	}
	
	if ($image->annotate('taguser', $friend, null,$user_id )) {

	   system_message(elgg_echo('taguser:sysnotify:sucessful'));
	  // echo "<pre>"; print_r($image->description); die;
	   
	   
	   // register to wall Post
	   if ( $image->description != null)
	   {
	   	
	    wallpost($user_id, sprintf(elgg_echo('taguser:wallpost:title'),$image->getURL(),$image->title),$image->description, $type="full", $access_id=ACCESS_PUBLIC);
	    
	    }
	    else if ( $image->title!= null )
	    {
	    	wallpost($user_id, sprintf(elgg_echo('taguser:wallpost:title'),$image->getURL(),$image->title),$image->title, $type="full", $access_id=ACCESS_PUBLIC);
	    }
	    
	    notify_user($user_id, $_SESSION['user']->getGUID(),' has tagged you at ',$image->title."-". $image->getURL()); 
	    
	}
	else 
	{
		 system_message(elgg_echo('taguser:sysnotify:fail'));
		
	}


	forward($_SERVER['HTTP_REFERER']);

?>
