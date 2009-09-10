<?php

/**
 * Elgg event calendar widget
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

	// Load event calendar model
	require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/models/model.php");

    //the number of events to display
	$num = (int) $vars['entity']->num_display;
	if (!$num)
		$num = 5;
		
    // Get the events

	$events = event_calendar_get_personal_events_for_user(page_owner(),$num);
		
	// If there are any events to view, view them
	if (is_array($events) && sizeof($events) > 0) {

		echo "<div id=\"widget_calendar\">";

		foreach($events as $event) {
			echo elgg_view("object/event_calendar",array('entity' => $event));
		}

		echo "</div>";
			
    }
	
?>