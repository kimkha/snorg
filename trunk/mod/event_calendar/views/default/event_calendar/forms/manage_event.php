<?php

/**
 * Elgg manage event view
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

extend_view('metatags','event_calendar/metatags');
	 
$event = $vars['event'];
$event_id = $vars['event_id'];
if ($event) {
	$title = $event->title;
	$brief_description = $event->description;
	$venue = $event->venue;
	$start_date = date("l, F j, Y",$event->start_date);
	if ($event->end_date) {
		$end_date = date("l, F j, Y",$event->end_date);
	} else {
		$end_date = $event->end_date;
	}
	$fees = $event->fees;
	$contact = $event->contact;
	$organiser = $event->organiser;
	$event_tags = $event->event_tags;
	$long_description = $event->long_description;
	$access = $event->access_id;
	$event_action = 'manage_event';
} else {
	$event_id = 0;
	$title = '';
	$brief_description = '';
	$venue = '';
	$start_date = '';
	$end_date = '';
	$fees = '';
	$contact = '';
	$organiser = '';
	$event_tags = '';
	$long_description = '';
	$access = ACCESS_PRIVATE;
	$event_action = 'add_event';
}
$body = '<div class="contentWrapper">';
$body .= '<p class="description">'.elgg_echo('event_calendar:manage_event_description').'</p>';
                    
$body .= '<form action="'.$vars['url'].'action/event_calendar/manage" method="post" >';

$body .= elgg_view('input/hidden',array('internalname'=>'event_action', 'value'=>$event_action));
$body .= elgg_view('input/hidden',array('internalname'=>'event_id', 'value'=>$event_id));
$body .= elgg_view('input/hidden',array('internalname'=>'group_guid', 'value'=>$vars['group_guid']));

$body .= '<p><label>'.elgg_echo("event_calendar:title_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'title','value'=>$title));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:title_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:venue_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'venue','value'=>$venue));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:venue_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:start_date_label").'<br />';
$body .= elgg_view("input/datepicker",array('internalname' => 'start_date','value'=>$start_date));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:start_date_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:end_date_label").'<br />';
$body .= elgg_view("input/datepicker",array('internalname' => 'end_date','value'=>$end_date));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:end_date_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:brief_description_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'brief_description','value'=>$brief_description));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:brief_description_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:fees_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'fees','value'=>$fees));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:fees_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:contact_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'contact','value'=>$contact));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:contact_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:organiser_label").'<br />';
$body .= elgg_view("input/text",array('internalname' => 'organiser','value'=>$organiser));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:organiser_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:event_tags_label").'<br />';
$body .= elgg_view("input/tags",array('internalname' => 'event_tags','value'=>$event_tags));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:event_tags_description').'</p>';

$body .= '<p><label>'.elgg_echo("event_calendar:long_description_label").'<br />';
$body .= elgg_view("input/longtext",array('internalname' => 'long_description','value'=>$long_description));
$body .= '</label></p>';
$body .= '<p class="description">'.elgg_echo('event_calendar:long_description_description').'</p>';

$body .= '<p><label>'.elgg_echo("access").'<br />';
$body .= elgg_view("input/access",array('internalname' => 'access','value'=>$access));
$body .= '</label></p>';

$body .= elgg_view('input/submit', array('internalname'=>'submit','value'=>elgg_echo('event_calendar:submit')));
$body .= '</form>';
$body .= '</div>';

print $body;
?>