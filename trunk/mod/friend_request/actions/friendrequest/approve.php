<?php

global $CONFIG;
gatekeeper();
action_gatekeeper();

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
			
	if (notify_user($friend->getGUID(),$user->getGUID(), "approve" , sprintf(elgg_echo('approve:content'),$friend->name, $user->name , $user->name, $user->name,$user->name) , NULL))	
		system_message(sprintf(elgg_echo('approve:system:notify'),$friend->name));						
	else
		register_error("can not approve");
	
	
	
	
	system_message(sprintf(elgg_echo('friendrequest:successful'), $friend->name));
	
	//echo "<pre>"; print_r($user); die;
	
		
	
	
	
} else {
	system_message(sprintf(elgg_echo('friendrequest:approvefail'), $friend->name));
}

forward($_SERVER['HTTP_REFERER']);
?>