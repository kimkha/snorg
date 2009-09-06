<?php

	/**
	 * Elgg internal messages plugin
	 * This plugin lets user send each other messages.
	 * 
	 * @package ElggMessages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	/**
	 * Messages initialisation
	 *
	 * These parameters are required for the event API, but we won't use them:
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */
	 
	    function sitenotification_init() {
    	    
    	    // Load system configuration
				global $CONFIG;
				
			// Extend the elgg taskbar
				extend_view('taskbar/extend','sitenotification/bottombar', 450);
				extend_view("css", "sitenotification/css");
				extend_view("js/initialise_elgg", "sitenotification/js");
			
			// Register a page handler, so we can have nice URLs
				register_page_handler('sitenotification','sitenotification_page_handler');
				
		//		register_entity_type('object', 'notification');
//				add_subtype('object', 'notification');
				
			// Register a notification handler for site messages
				register_notification_handler("sitenotification", "site_notify_handler");
				
				//register_plugin_hook('notify:entity:message','object','sitenotification_msg');
				
			}
			
		function sitenotification_msg($hook_name, $entity_type, $return_value, $parameters){
			$target_objname = $parameters['entity']->getSubtype();
			
			if ($parameters['entity']->getSubtype() == 'blog'){
				$target_objname = 'a new blog post';
			}
			
			return $target_objname . '-' . $parameters['entity']->getURL();
			
			
		}	
		
		function sitenotification_page_handler($page) {
			
			// The first component of a messages URL is the username
			
			
			// The second part dictates what we're doing
			@include(dirname(__FILE__) . "/index.php");
			return true;
			
			
		}

		/**
		 * Send an internal message
		 *
		 * @param string $subject The subject line of the message
		 * @param string $body The body of the mesage
		 * @param int $send_to The GUID of the user to send to
		 * @param int $from Optionally, the GUID of the user to send from
		 * @param int $reply The GUID of the message to reply from (default: none)
		 * @param true|false $notify Send a notification (default: true)
		 * @param true|false $add_to_sent If true (default), will add a message to the sender's 'sent' tray
		 * @return true|false Depending on success
		 */
		function save_notification($from, $to , $action, $objectname = 0, $message = 0) {
		    // Initialise a new ElggObject
					$notification_message = new ElggObject();
					
			// Tell the system it's a message
					$notification_message->subtype = "notification";
					
			// Set its owner to the current user
					
					$notification_message->owner_guid = $from->getGUID();
					$notification_message->to = $to->getGUID();
					$notification_message->title = $action;
					$notification_message->description = $message;
					$notification_message->read_yet = 0;
					
					
			
					
			    // Save the copy of the message that goes to the recipient
					$success = $notification_message->save();
					    
					   
			        return $success;	
		}
		
		
		/**
		 * messages page handler; allows the use of fancy URLs
		 *
		 * @param array $page From the page_handler function
		 * @return true|false Depending on success
		 */
		
		
		function site_notify_handler(ElggEntity $from, ElggUser $to, $subject, $message, array $params = NULL)
		{
			
			
			global $CONFIG;
			
			if (!$from)
				throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'from'));
				 
			if (!$to)
				throw new NotificationException(sprintf(elgg_echo('NotificationException:MissingParameter'), 'to'));
				
			
				return save_notification($from,$to,$subject,'0',$message);
			
		}
		
		
		function count_unread_sitenotification(){
			$num_notification = get_entities_from_metadata_multi(array(
		    							'to' => $_SESSION['user']->guid,
		    							'read_yet' => 0,
		    									   ),"object", "notification", 0 , 9999, 0, "", 0, false);
		
			if (is_array($num_notification))
				$counter = sizeof($num_notification);
			else
				$counter = 0;
				
		    return $counter;
            
		}
	
		function mark_all_as_read(){
			$notyetread_notifications = get_entities_from_metadata_multi(array (
										'to' => $_SESSION['user']->guid,
										'read_yet' => 0,
										), 'object', 'notification',0, 9999, 0,"",0,false);
			foreach ($notyetread_notifications as $notification){
				$notification->read_yet = 1;
			}
            
		}
	
		
	// Make sure the messages initialisation function is called on initialisation
		register_elgg_event_handler('init','system','sitenotification_init');
		
				
	// Register actions
		global $CONFIG;
	 
?>