
<?php
	
	
	
	//$notifications = get_entities("object", 'notification');
//	$user_notifications = array();
//	$i=0;
//	foreach ($notifications as $notification){
//		 
//		if ( ($notification->to != null) && ($notification->to == '10' )){
//						
//			$user_notifications[$i]=$notification;
//			$i = $i + 1 ;
//		}
//		
//	}
	
	$user_notifications = get_entities_from_metadata('to',$_SESSION['user']->guid, 'object', 'notification',0, 9999, 0,"",0,false);
	
	//$user_notifications = get_entities('object', 'notification',0, "", 9999, 0,false);
	
	
	
	foreach ($user_notifications as $notification){
		
		$from_user = get_user($notification->container_guid);
		$action = $notification->title;
		
		$target_object = split('-', $notification->description);	
		
		echo "<div class=\"contentWrapper\">";
		echo "<a href=\"". $from_user->getURL(). "\">" . $from_user->username . "</a>";
		echo " ". $action; 
		echo " ". "<a href=\"". $target_object[1] . "\">" . $target_object[0] . "</a>";
		echo "</div>";
	}
?>


