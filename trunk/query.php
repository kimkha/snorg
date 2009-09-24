<?php
        require_once(dirname(__FILE__) . "/engine/start.php");


        //Get guid of page owener
        $action = get_input('action');
        
			header("Content-Type: application/json; charset=UTF-8");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");

        if ($action == 'GetFriends'){
	        //
	        //Get all friends of page owner
	        $owner =  get_user(get_input('owner'));
	        $friends = $owner->getFriends();        
	        
	        //response xml data of all page owner friends
	        
	        $friends_info = array();

	        foreach ($friends as $friend){
				$friends_info[] = array($friend->username,$friend->getURL(),$friend->getIcon('tiny'));
	        }
	        
	        echo json_encode($friends_info);
	        
	        
	   } else if ($action == 'calendar'){
	        $relationship = get_input("relationship");
	        //Get all friends of page owner
	        $event_guid =  get_input('owner');
	        
	        $attender = get_entities_from_relationship($relationship, $event_guid, false, 'user');     
	        
	        //response xml data of all page owner friends
	        
	        $attenders_info = array();

	        foreach ($attender as $friend){
				$attenders_info[] = array($friend->username,$friend->getURL(),$friend->getIcon('tiny'));
	        }
	        
	        echo json_encode($attenders_info);
	        
	        
	   } else if ($action == 'GetSitenotification'){
	   		$user_guid =  get_input('user_guid');
	   		
			$user_notifications = get_unread_notification($user_guid);
	   		
	   		$user_notifications_json = array();
			
			$count = 0;
			foreach ($user_notifications as $notification){
				$notification_json = array();
				$from_user = get_user($notification->container_guid);
				$action = $notification->title;
		
				$target_object = split('-', $notification->description);
				
				    	            
				$notification_json[0] = $from_user->username;
				$notification_json[1] = $from_user->getURL();
				$notification_json[2] = $action;
				$notification_json[3] = $target_object[0]; //object name
				$notification_json[4] = $target_object[1]; //object url
				$user_notifications_json[] = $notification_json;
				                   
	        }
	        
	   		//Mark all as read
			mark_all_as_read($user_guid);   	
			/////////////
			
	        echo json_encode($user_notifications_json);
	   		
	   } else if ($action == 'GetUnreadSitenotification'){
	   		$user_guid =  get_input('user_guid');
	   		
	   		
	   		$user_notifications = get_unread_notification($user_guid);
	   		
	   		$user_notifications_json = array();
			
			foreach ($user_notifications as $notification){
				$notification_json = array();
				$from_user = get_user($notification->container_guid);
				$action = $notification->title;
		
				$target_object = split('-', $notification->description);
				
				    	            
				$notification_json[0] = $from_user->username;
				$notification_json[1] = $from_user->getURL();
				$notification_json[2] = $action;
				$notification_json[3] = $target_object[0]; //object name
				$notification_json[4] = $target_object[1]; //object url
				
				$user_notifications_json[] = $notification_json;
				                   
	        }
	        
	        //Mark all as read
			mark_all_as_read($user_guid);   	
			/////////////
				
	        echo json_encode($user_notifications_json);
	   		
	   } else if ($action == 'GetNewSitenotificationCount'){
	   		$user_guid = get_input('user_guid');
	   		echo json_encode(array('count' => count_unread_sitenotification($user_guid)));
	   } else if ($action == 'GetPeopleYouMayKnow'){
	   	
	   		$page_owner = get_loggedin_user();
	   		$list = people_you_might_know_get_entities($page_owner->getGUID());
	   		$list_json = array();
	   		
	   		$count = 0;
	   		
	   		if ( count($list) > 0)
			{
				foreach ($list as $people)
					{
						$people_json = array($people->username, $people->getURL(),$people->getIcon("small"));
						$list_json[$count++]=$people_json;				
					}
				
			}
			
			echo json_encode($list_json);
	   }
	   else if ( $action == 'GetMutualFriends'){
			   		
 			$owner = get_user(get_input('owner'));
			
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
			
			$mutual_array = array();
			
			foreach ($mutural as $mfriend)
			{
				$mutual_array[] = array($mfriend->username, $mfriend->getURL(), $mfriend->getIcon("small"));
			}

	   		echo json_encode($mutual_array);
	   }
        
 ?>
