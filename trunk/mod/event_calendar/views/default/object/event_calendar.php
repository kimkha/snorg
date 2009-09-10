<?php

/**
 * Elgg event_calendar object view
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */
// Load event calendar model
require_once(dirname(dirname(dirname(dirname(__FILE__))))."/models/model.php");

//	extend_view('owner_block/extend','event_calendar/owner_block');

$date_format = 'j M Y';

$event = $vars['entity'];

$start_date = date($date_format,$event->start_date);
if ((!$event->end_date) || ($end_date == $start_date)) {
	$time_bit = $start_date;
} else {
	$end_date = date($date_format,$event->end_date);
	$time_bit = "$start_date - $end_date";
}

if ($vars['full']) {
	$event_items = array();
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:when_label');
	$item->value = $time_bit;
	$event_items[] = $item;
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:venue_label');
	$item->value = htmlspecialchars($event->venue);
	$event_items[] = $item;
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:fees_label');
	$item->value = htmlspecialchars($event->fees);
	$event_items[] = $item;
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:organiser_label');
	$item->value = htmlspecialchars($event->organiser);
	$event_items[] = $item;
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:contact_label');
	$item->value = htmlspecialchars($event->contact);
	$event_items[] = $item;
	$item = new stdClass();
	$item->title = elgg_echo('event_calendar:event_tags_label');
	$item->value = elgg_view("output/tags",array('value'=>$event->event_tags));
	$event_items[] = $item;
	$body = '<div class="contentWrapper" >';
	foreach($event_items as $item) {
		$value = $item->value;
		if (!empty($value)) {
				
			//This function controls the alternating class
			$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
			$body .= "<p class=\"{$even_odd}\"><b>";
			$body .= $item->title.':</b> ';
			$body .= $item->value;

		}
	}
	echo $body;
	
	if ($event->long_description) {
		echo '<p>'.$event->long_description.'</p>';
	} else {
		echo '<p>'.$event->description.'</p>';
	}
	echo '</div>';
	
	echo elgg_view("event_calendar/attend", array('entity'=>$event));
	
	echo elgg_view_comments($event);
} else {
	$icon = elgg_view(
			"graphics/icon", array(
			'entity' => $vars['entity'],
			'size' => 'small',
		  )
		);
	$info .= '<p><b><a href="'.$vars['entity']->getUrl().'">'.$event->title.'</a></b>';
	if ($event->description) {
		$info .= '<br />'.$event->description;
	}
	
	$info .= '<br />'.$time_bit;
	$info .=  '</p>';
	
		
	echo elgg_view_listing($icon, $info);
}

?>