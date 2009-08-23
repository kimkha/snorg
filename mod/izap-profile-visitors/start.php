<?php
	/**
	 * iZAP izap profile visitor
	 * 
	 * @license GNU Public License version 3
	 * @author iZAP Team "<support@izap.in>"
	 * @link http://www.izap.in/
	 * @version 1.1
	 * @compatibility elgg-1.5
	 */

function izapProfileVisitors()
{
	global $CONFIG;
	
	// this is init function
	add_widget_type('izapProfileVisitors', elgg_echo('izapProfileVisitor:Widget'), elgg_echo('izapProfileVisitor:WidgetDescription'));
	extend_view('css', 'izapprofilevisitor/css');
  extend_view('profile/userdetails', 'izapprofilevisitor/userdetails', 1);
}
include($CONFIG->pluginspath . 'izap-profile-visitors/includes/lib.php');

// registering the pluing
register_elgg_event_handler('init', 'system', 'izapProfileVisitors', 10000);
?>