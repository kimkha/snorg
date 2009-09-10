<?php
	/**
	 * Invite users to groups
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	
	
	gatekeeper();
	
	$event_id = (int) get_input('event_id');
	$event = get_entity($event_id);
//echo "<pre>"; print_r($event); die;
	set_page_owner($event_id);

	$title = elgg_echo("groups:invite");

	$area2 = elgg_view_title($title);
	
	
	
	if (($event) && ($event->canEdit()))
	{	
		$area2 .= elgg_view("eventrequest/invite", array('entity' => $event));
		
//	echo "<pre>"; print_r($entity); die;
			 
	} else {
		$area2 .= elgg_echo("groups:noaccess");
			
	}
	
	$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	//echo "<pre>"; print_r("hoai"); die;
	page_draw($title, $body);
?>