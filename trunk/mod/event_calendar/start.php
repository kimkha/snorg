<?php

	/**
	 *  Event calendar plugin
	 * 
	 * @package RIBA event
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Kevin Jardine <kevin@radagast.biz>
	 * @copyright Radagast Solutions 2008
	 * @link http://radagast.biz/
	 */
	// Load event calendar model
	require_once(dirname(__FILE__) . "/models/model.php");
	/**
	 * event calendar initialisation
	 *
	 * These parameters are required for the event API, but we won't use them:
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */

	function event_calendar_init() {
		
		// Load system configuration
		global $CONFIG;
		
	
			
		// Load the language files
		register_translations($CONFIG->pluginspath . "event_calendar/languages/");
		
		// register for invite friend attend event  - snorg - bkit06
	
		extend_view('css','eventrequest/css');
	
		//Extend topbar to add our link if needed  - snorg - bkit06
		extend_view('elgg_topbar/extend','eventrequest/topbar');
		
		
		// snorg - bkit06 
		if ( get_context() == "showevent" ){
			extend_view('owner_block/extend','event_calendar/owner_block');
			
		}
			
					
		// Register a page handler, so we can have nice URLs
		register_page_handler('event_calendar','event_calendar_page_handler');
		
		//This will let uesrs view their event invite - snorg - bkit06
		register_page_handler('eventrequests','eventrequests_page_handler');
		
		
		
		// Register URL handler
		register_entity_url_handler('event_calendar_url','object', 'event_calendar');
		
		// Register granular notification for this type
		if (is_callable('register_notification_object'))
			register_notification_object('object', 'event_calendar', elgg_echo('event_calendar:new_event'));
			
		// Set up menu for users
		if (isloggedin()) {
			$site_calendar = get_plugin_setting('site_calendar', 'event_calendar');
			if (!$site_calendar || $site_calendar != 'no') {			
				add_menu(elgg_echo('item:object:event_calendar'), $CONFIG->wwwroot . "pg/event_calendar/");
			}
		}
		
		//add to group profile page
		$group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
		if (!$group_calendar || $group_calendar != 'no') {
			$group_profile_display = get_plugin_setting('group_profile_display', 'event_calendar');
			if (!$group_profile_display || $group_profile_display == 'right') {
				extend_view('groups/right_column', 'event_calendar/groupprofile_calendar');
			} else if ($group_profile_display == 'left') {
				extend_view('groups/left_column', 'event_calendar/groupprofile_calendar');
			}
		}
		
		//add to the css
		extend_view('css', 'event_calendar/css');
		
		//add a widget
		add_widget_type('event_calendar',elgg_echo("event_calendar:widget_title"),elgg_echo('event_calendar:widget:description'));
		
		// add the event calendar group tool option
		if (function_exists('add_group_tool_option')) {
			$event_calendar_group_default = get_plugin_setting('group_default', 'event_calendar');
			if (!$event_calendar_group_default || ($event_calendar_group_default == 'yes')) {
				add_group_tool_option('event_calendar',elgg_echo('event_calendar:enable_event_calendar'),true);
			} else {
				add_group_tool_option('event_calendar',elgg_echo('event_calendar:enable_event_calendar'),false);
			}
		}
		
	}
	
	function event_calendar_pagesetup() {
		
		global $CONFIG;
		
		$page_owner = page_owner_entity();
		
		$context = get_context();
		
		// Group submenu option	
		if ($page_owner instanceof ElggGroup && $context == 'groups') {
			$group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
			if (!$group_calendar || $group_calendar != 'no') {
				if (!$page_owner->event_calendar_enable || $page_owner->event_calendar_enable != 'no') {
					add_submenu_item(elgg_echo("event_calendar:group"), $CONFIG->wwwroot . "pg/event_calendar/group/" . $page_owner->getGUID());
				}
			}
		} else if ($context == 'event_calendar'){
			add_submenu_item(elgg_echo("event_calendar:site_wide_link"), $CONFIG->wwwroot . "pg/event_calendar/");
			$site_calendar = get_plugin_setting('site_calendar', 'event_calendar');
			if (!$site_calendar || $site_calendar == 'admin') {
				if (isloggedin()) {
					// only admins can post directly to the site-wide calendar
					add_submenu_item(elgg_echo('event_calendar:new'), $CONFIG->url . "pg/event_calendar/new/", 'eventcalendaractions');
				}
			} else if ($site_calendar == 'loggedin') {
				// any logged-in user can post to the site calendar
				if (isloggedin()) {
					add_submenu_item(elgg_echo('event_calendar:new'), $CONFIG->url . "pg/event_calendar/new/", 'eventcalendaractions');
				}
			}
		}
		
		if (($context == 'groups') || ($context == 'event_calendar')) {
			if (($event_id = get_input('event_id',0)) && ($event = get_entity($event_id))) {
				add_submenu_item(elgg_echo("event_calendar:view_link"), $CONFIG->wwwroot . "pg/event_calendar/view/" . $event_id,'0eventcalendaradmin');
				if ($event->canEdit()) {
					add_submenu_item(elgg_echo("event_calendar:edit_link"), $CONFIG->wwwroot . "mod/event_calendar/manage_event.php?event_id=" . $event_id,'0eventcalendaradmin');
					
					add_submenu_item(elgg_echo("event_calendar:delete_link"), $CONFIG->wwwroot . "mod/event_calendar/delete_confirm.php?event_id=" . $event_id,'0eventcalendaradmin');
					//add_submenu_item(elgg_echo("event_calendar:edit_link"), $CONFIG->wwwroot . "mod/event_calendar/manage_event.php?event_id=" . $event_id,'0eventcalendaradmin');
					// snorg - bkit06
					add_submenu_item(elgg_echo("event_calendar:invite"),$CONFIG->wwwroot . "mod/event_calendar/invite.php?event_id=" . $event_id, '0eventcalendaradmin');
				}				
			}
		}
    }
    
    function event_calendar_url($entity) {		
		global $CONFIG;		
		return $CONFIG->url . 'pg/event_calendar/view/'.$entity->getGUID();		
	}
	
	/**
	 * Page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function event_calendar_page_handler($page) {
		if (isset($page[0]) && $page[0]) {
			if (($page[0] == 'group') && isset($page[1])) {
				set_input('group_guid',$page[1]);
				if (isset($page[2])) {
					set_input('filter',$page[2]);
				}
				@include(dirname(__FILE__) . "/show_events.php");
			} else if (($page[0] == 'view') && isset($page[1])) {
				set_input('event_id',$page[1]);
				@include(dirname(__FILE__) . "/show_event.php");
			} else if ($page[0] == 'new') {
				@include(dirname(__FILE__) . "/manage_event.php");
			} else if (in_array($page[0],array('all','friends','mine'))) {
				set_input('filter',$page[0]);
				@include(dirname(__FILE__) . "/show_events.php");
			}
		} else {
			@include(dirname(__FILE__) . "/show_events.php");
		}
		return true;		
	}
	
	function eventrequests_page_handler($page_elements) {
	global $CONFIG;
	
	//Keep the URLs uniform:
	if (isset($page_elements[1])) {
		forward("pg/eventrequests");
	}
	
	include($CONFIG->pluginspath . "event_calendar/list.php"); 
}
	
	function count_events_requests() {
	global $CONFIG;
	return get_entities_from_relationship('eventrequest', $_SESSION['user']->guid, true, "", "", 0, "", 0, 0, true);
}

	
// Make sure the event calendar functions are called
	register_elgg_event_handler('init','system','event_calendar_init');
	register_elgg_event_handler('pagesetup','system','event_calendar_pagesetup');
	
// Register actions

	global $CONFIG;
	register_action("event_calendar/manage",false,$CONFIG->pluginspath . "event_calendar/actions/manage.php");
	
	
// snorg - bkit06 register action
	
	// snorg - bkit06 register action //This overwrites the original friend requesting stuff.
	register_action("eventrequest/invite", false, $CONFIG->pluginspath . "event_calendar/actions/invite.php", false);
	
	// snorg - bkit06 register action //Our friendrequest handlers...
	register_action("eventrequest/attend", false, $CONFIG->pluginspath . "event_calendar/actions/attend.php");
	
	// snorg - bkit06 register action
   	register_action("eventrequest/notattend", false, $CONFIG->pluginspath . "event_calendar/actions/not_attend.php");
   	// snorg - bkit06 register action
   	register_action("eventrequest/maybeattend", false, $CONFIG->pluginspath . "event_calendar/actions/maybe_attend.php");

?>