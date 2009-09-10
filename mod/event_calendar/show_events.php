<?php

/**
 * Show events
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

// Load event model
require_once(dirname(__FILE__) . "/models/model.php");
    
// Define context
set_context('event_calendar');

global $CONFIG;

$event = '';

$original_start_date = get_input('start_date',date('Y-m-d'));

// the default interval is one month
$day = 60*60*24;
$week = 7*$day;
$month = 31*$day;

$mode = trim(get_input('mode',''));

if ($mode == "day") {
	$start_date = $original_start_date;
	$end_date = $start_date;
	$start_ts = strtotime($start_date);
	$end_ts = strtotime($end_date);
	$subtitle = elgg_echo('event_calendar:day_label').': '.date('j F Y',strtotime($start_date));
} else if ($mode == "week") {
	// need to adjust start_date to be the beginning of the week
	$start_ts = strtotime($original_start_date);
	$start_ts -= date("w",$start_ts)*$day;
	$end_ts = $start_ts + 6*$day;
	
	$start_date = date('Y-m-d',$start_ts);
	$end_date = date('Y-m-d',$end_ts);
	$subtitle = elgg_echo('event_calendar:week_label').': '.date('j F',$start_ts) . ' - '.date('j F Y',$end_ts);
} else {
	$start_ts = strtotime($original_start_date);
	$month = date('m',$start_ts);
	$year = date('Y',$start_ts);
	$start_date = $year.'-'.$month.'-1';
	$end_date = $year.'-'.$month.'-'.getLastDayOfMonth($month,$year);
	$start_ts = strtotime($start_date);
	$end_ts = strtotime($end_date);
	$subtitle = elgg_echo('event_calendar:month_label').': '.date('F Y',$start_ts);
}

$group_guid = (int) get_input('group_guid',0);
if ($group_guid && $group = get_entity($group_guid)) {
	// redefine context
	set_context('groups');
	set_page_owner($group_guid);
	$group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
	if (!$group_calendar || $group_calendar == 'members') {
		if (page_owner_entity()->canWriteToContainer($_SESSION['user'])){
			add_submenu_item(elgg_echo('event_calendar:new'), $CONFIG->url . "pg/event_calendar/new/?group_guid=" . page_owner(), '1eventcalendaradmin');
		}
	} else if ($group_calendar == 'admin') {
		if (isadminloggedin() || ($group->owner_guid == get_loggedin_userid())) {				
			add_submenu_item(elgg_echo('event_calendar:new'), $CONFIG->url . "pg/event_calendar/new/?group_guid=" . page_owner(), '1eventcalendaradmin');
		}
	}
}

$offset = (int) get_input('offset',0);
$limit = 10;
$filter = get_input('filter','all');
if ($filter == 'all') {
	$count = event_calendar_get_events_between($start_ts,$end_ts,true,$limit,$offset,$group_guid);
	$events = event_calendar_get_events_between($start_ts,$end_ts,false,$limit,$offset,$group_guid);
} else if ($filter == 'friends') {
	$user_guid = get_loggedin_userid();
	$count = event_calendar_get_events_for_friends_between($start_ts,$end_ts,true,$limit,$offset,$user_guid,$group_guid);
	$events = event_calendar_get_events_for_friends_between($start_ts,$end_ts,false,$limit,$offset,$user_guid,$group_guid);	
} else if ($filter == 'mine') {
	$user_guid = get_loggedin_userid();
	$count = event_calendar_get_events_for_user_between($start_ts,$end_ts,true,$limit,$offset,$user_guid,$group_guid);
	$events = event_calendar_get_events_for_user_between($start_ts,$end_ts,false,$limit,$offset,$user_guid,$group_guid);	
}

extend_view('metatags','event_calendar/metatags');

$vars = array(	'original_start_date' => $original_start_date,
			'start_date'	=> $start_date,
			'end_date'		=> $end_date,
			'mode'			=> $mode,
			'events'		=> $events,
			'count'			=> $count,
			'offset'		=> $offset,
			'limit'			=> $limit,
			'group_guid'	=> $group_guid,
			'filter'		=> $filter,
);

$callback = get_input('callback','');

if ($callback) {
	if (isloggedin()) {
		$nav = elgg_view('event_calendar/nav',$vars);
	} else {
		$nav = '';
	}
	if ($events) {
		$event_list = elgg_view_entity_list($events, $count, $offset, $limit, true, false);
	} else {
		$event_list = '<p>'.elgg_echo('event_calendar:no_events_found').'</p>';
	}
	echo $nav.'<br />'.$event_list;
} else {

	$body = elgg_view('event_calendar/show_events', $vars);
		
	$title = elgg_echo('event_calendar:show_events_title'). ' ('.$subtitle.')';
	
	$body = elgg_view('page_elements/contentwrapper',array('body' =>$body, 'subclass' => 'events'));
		
	page_draw($title,elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title).$body));
}

function getLastDayOfMonth($month,$year) {
	return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
}


?>