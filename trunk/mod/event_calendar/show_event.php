<?php

/**
 * Show event
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */
 
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Load event calendar model
require_once(dirname(__FILE__) . "/models/model.php");
    
// Define context
set_context('event_calendar');

global $CONFIG;

$event_id = get_input('event_id',0);
if ($event_id && ($event = get_entity($event_id))) {
	$event_container = get_entity($event->container_guid);
	if ($event_container instanceOf ElggGroup) {
		// Re-define context
		set_context('groups');
		set_page_owner($event_container->getGUID());
	}
	
	$count = event_calendar_get_users_for_event($event_id,0,0,true);
	if ($count > 0) {
	//	add_submenu_item(sprintf(elgg_echo('event_calendar:personal_event_calendars_link'),$count), $CONFIG->url . "mod/event_calendar/display_event_users.php?event_id=".$event_id, '0eventnonadmin');
	}
	if (isloggedin()) {
		if (event_calendar_has_personal_event($event_id,$_SESSION['user']->getGUID()) && ( get_entities_from_relationship('eventattend',$event_id,null,'user'))) {
			add_submenu_item(elgg_echo('event_calendar:remove_from_my_calendar'), $CONFIG->url . "action/event_calendar/manage?event_action=remove_personal&event_id=".$event_id, '0eventnonadmin');
		} else {
			add_submenu_item(elgg_echo('event_calendar:add_to_my_calendar'), $CONFIG->url . "action/event_calendar/manage?event_action=add_personal&event_id=".$event_id, '0eventnonadmin');
		}
	}
	$body = elgg_view('object/event_calendar',array('entity'=>$event,'full'=>true));
	$title = $event->title;
	$block = elgg_view("event_calendar/owner_block", array('entity'=>$event,'full'=>true));
	$content = elgg_view_layout("two_column_left_sidebar", "", elgg_view_title($title) . $body, $block);
	page_draw($title, $content);
} else {
	register_error('event_calendar:error_nosuchevent');
	forward();
}
?>