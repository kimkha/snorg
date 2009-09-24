<?php

	/**
	 * Elgg profile plugin edit default profile action
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
		
	// Load configuration
	global $CONFIG;
		
	action_gatekeeper();
	admin_gatekeeper();
	
	
	$label = sanitise_string(get_input('label'));
	$type = sanitise_string(get_input('type'));
	
	if (($label) && ($type))
	{
		$n = 0;
		while (get_plugin_setting("admin_defined_cv_$n", 'cv')) {$n++;} // find free space
		
		if ( (set_plugin_setting("admin_defined_cv_$n", $label, 'cv')) && 
			(set_plugin_setting("admin_defined_cv_type_$n", $type, 'cv')))
			system_message(elgg_echo('cv:editdefault:success'));
		else
			register_error(elgg_echo('cv:editdefault:fail'));
			
	}
	else
		register_error(elgg_echo('cv:editdefault:fail'));
	
	forward($_SERVER['HTTP_REFERER']);
?>