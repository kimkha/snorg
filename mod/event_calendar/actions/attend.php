<?php
	/**
	 * Join a group action.
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	// Load configuration
	global $CONFIG;
	
	gatekeeper();
	
	$user_guid = get_input('user_guid', get_loggedin_userid());
	$event_guid = get_input('event_guid');
	
	$user = get_entity($user_guid);
	$event = get_entity($event_guid);
	


if(remove_entity_relationship($event_guid, 'eventrequest', $user_guid)) {
	
	
	if(add_entity_relationship($event_guid,'eventattend', $user_guid))
	{
		forward($CONFIG->url . "action/event_calendar/manage?event_action=add_personal&event_id=".$event_guid);
		if (notify_user($event->owner_guid,$user->getGUID(), " Accept to addtend your event" , NULL))	
		system_message("okie");						
	else
		register_error("can not notify");
//	echo "<pre>"; print_r("hoai"); die;
	
	
	
	system_message(" your confirm has been work");
	}
  	
	// send notify to friend when approve
	// Snorg - Bkit06	
	
	
	//echo "<pre>"; print_r($user); die;
	
		
	
	
	
} else {
	system_message(" Sorry it has some problem with your system");
}

forward($_SERVER['HTTP_REFERER']);


?>