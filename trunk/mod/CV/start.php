<?php
function cv_init(){
	
	extend_view('profile/tabs', 'cv/profile_tab', 450);
	
	extend_view('css', 'cv/css');
	
	register_page_handler('cv', cvedit_page_handler);	
	
}
	
function cvedit_page_handler($page){
	GLOBAL $CONFIG;
	
	
	if (isset($page[0])){
		switch ($page[0]){
			case 'edit':
				include($CONFIG->pluginspath . "cv/defaultcv.php");
				default:    
				
		}		
	}
}

function cv_pagesetup()
{
	if (get_context() == 'admin' && isadminloggedin()) {
		global $CONFIG;
		add_submenu_item(elgg_echo('cv:edit:default'), $CONFIG->wwwroot . 'pg/cv/edit/');
	}
}

function cv_fields_setup()
{
	global $CONFIG;
	
	$cv_defaults = array (
	);
	
	// TODO: Have an admin interface for this
	
	$n = 0;
	$loaded_defaults = array();
	while (get_plugin_setting("admin_defined_cv_$n", 'cv'))
	{
				
		$lable = get_plugin_setting("admin_defined_cv_$n", 'cv');
		// Detect type
		$type = get_plugin_setting("admin_defined_cv_type_$n", 'cv');
		if (!$type) $type = 'text';
		
		// Set array
		$loaded_defaults[$lable] = $type;
		
		$n++;
	}
	if (count($loaded_defaults)) {
		$CONFIG->cv_using_custom = true;
		$cv_defaults = $loaded_defaults;
	}
	
	$CONFIG->cv = trigger_plugin_hook('cv:fields', 'cv', $cv_defaults, $cv_defaults);
}
		
		
register_elgg_event_handler('init','system','cv_init');
register_elgg_event_handler('pagesetup','system','cv_pagesetup');
register_elgg_event_handler('init','system','cv_fields_setup', 9999); // Ensure this runs after other plugins

global $CONFIG;


register_action("cv/edit",false,$CONFIG->pluginspath . "cv/actions/edit.php");
register_action("cv/editdefault",false,$CONFIG->pluginspath . "cv/actions/editdefault.php", true);
register_action("cv/editdefault/reset",false,$CONFIG->pluginspath . "cv/actions/resetdefaultcv.php", true);
register_action("cv/cv_tab",false,$CONFIG->pluginspath . "cv/actions/profile_tab.php");


?>