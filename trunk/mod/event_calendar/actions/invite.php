<?php

	/**
	 * Invite a user to join a group
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
	
	$user_guid = get_input('user_guid');
	
	if (!is_array($user_guid))
		$user_guid = array($user_guid);
	$event_guid = get_input('event_guid');
	
	if (sizeof($user_guid))
	{
		foreach ($user_guid as $u_id)
		{
			$user = get_entity($u_id);
			$event = get_entity($event_guid);
			
			if ( $user && $event) {
				
				if (get_loggedin_userid() == $event->owner_guid)
				{
					
						
					
					if( (!check_entity_relationship($event->guid, 'eventrequest', $user->guid))&&(!check_entity_relationship($event->guid, 'eventattend', $user->guid)) && (!check_entity_relationship($event->guid, 'eventmaybeattend', $user->guid))  )
					{
						if ($user->isFriend())
						{
							
							// Create relationship
							add_entity_relationship($event->guid, 'eventrequest', $user->guid);
							
							// Send email
							// Snorg - Bkit06
							
							if (notify_user($user->getGUID(), $event->owner_guid, " invite you to Gourp ".$event->name))
								system_message(elgg_echo("event:notify:userinvited"));
							else
								register_error(elgg_echo("event:notify:usernotinvited"));
							
						}
						else
							register_error(elgg_echo("event:usernotinvited"));
					}
					else
						register_error(elgg_echo("event:useralreadyinvited"));
				
						
				}
				else
					register_error(elgg_echo("event:notowner"));
			}
		}
	}
	
	forward($_SERVER['HTTP_REFERER']);
	
?>