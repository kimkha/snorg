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

	               	
	        $count =0;
	        foreach ($friends as $friend){
				$friend_info = array($friend->username,$friend->getURL(),$friend->getIcon('tiny'));
 				$friends_info[$count++] = $friend_info;
   			   
	        }
	        
	        echo json_encode($friends_info);
	        
	        
	   } else if ($action == 'GetSitenotification'){
	   		$user_guid =  get_input('user_guid');
	   		
	   		//Mark all as read
			mark_all_as_read();   	
			/////////////
				
	   		$user_notifications = get_entities_from_metadata('to',$user_guid, 'object', 'notification',0, 9999, 0,"",0,false);
	   		$user_notifications_json = array();
			//echo "<pre>"; print_r($user_notifications); die;
			
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
				
				$user_notifications_json[$count++] = $notification_json;
				                   
	        }
	        echo json_encode($user_notifications_json);
	   		
	   } else if ($action == 'GetNewSitenotificationCount'){
	   		echo count_unread_sitenotification();
	   }
        
 ?>
