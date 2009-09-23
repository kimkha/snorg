<?php

global $CONFIG;
gatekeeper();

$user = $_SESSION['user'];
if(!$friend = get_entity(get_input("guid",0))) {
	exit;
}



if(remove_entity_relationship($friend->guid, 'friendrequest', $user->guid)) {
	if(isset($CONFIG->events['create']['friend'])) {
		$oldEventHander = $CONFIG->events['create']['friend'];
		$CONFIG->events['create']['friend'] = array();		//Removes any event handlers
	}
	
	$_SESSION['user']->addFriend($friend->guid);
	$friend->addFriend($_SESSION['user']->guid); //Friends mean reciprical...
	
	$approve = new ElggObject();
	$approve->title = "hoai";
	$approve->dserciption ="hoai";
	$approve->subtype = "approve";
	$approve->owner_guid = $user->getGUID();
	$approve->save();			
	
	if(isset($CONFIG->events['create']['friend'])) {
		$CONFIG->events['create']['friend'] = $oldEventHander;
	}		
	
  	
	// send notify to friend when approve
	//snorg - bkit06 - wallpost
		
		wallpost($user->getGUID(), sprintf(elgg_echo('friendrequest:wallpost:title'),$friend->username,$friend->name),null, $type="short", $access_id=ACCESS_PUBLIC);
		wallpost($friend->getGUID(), sprintf(elgg_echo('friendrequest:wallpost:title'),$user->username,$user->name),null, $type="short", $access_id=ACCESS_PUBLIC);
		
	//snorg - bkit06 - eng
	notify_user($friend->getGUID(),$user->getGUID(), elgg_echo('approve:system:notification') , NULL);
	
	//snorg - bkit06 - viet
//	notify_user($friend->getGUID(),$user->getGUID(), "ау ch?p nh?n l?i m?i k?t b?n c?a b?n." , NULL);						

	
	system_message(sprintf(elgg_echo('friendrequest:successful'), $friend->name));
	
	
} else {
	system_message(sprintf(elgg_echo('friendrequest:approvefail'), $friend->name));
}

forward($_SERVER['HTTP_REFERER']);
?>