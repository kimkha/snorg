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
//	global $CONFIG;
	
	gatekeeper();
	
	$user_guid = get_input('user_guid', get_loggedin_userid());
	$event_guid = get_input('event_guid');
	
	$user = get_entity($user_guid);
	$event = get_entity($event_guid);
	


if(remove_entity_relationship($event_guid, 'eventrequest', $user_guid)) {
	
	

	system_message(" you has canceled invitation");
	
  	
	// send notify to friend when approve
	// Snorg - Bkit06	
	
	
	//echo "<pre>"; print_r($user); die;

	
} else {
	system_message(" Sorry it has some problem with your system");
}

forward($_SERVER['HTTP_REFERER']);


?>