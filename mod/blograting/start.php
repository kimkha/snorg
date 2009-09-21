<?php
	
	function blograte_init(){
		
		extend_view('css','blograte/css');
		extend_view("js/initialise_elgg", "blograte/js");
		
		
	}

	function insert_toprate_entries($hook, $type, $returnvalue, $params){
		$returnvalue['TOP ENTRIES'] = 'readonly';
		return $returnvalue;		
	}
	
	global $CONFIG;
	register_elgg_event_handler('init','system',blograte_init);
	register_action("blograting/rate",false,$CONFIG->pluginspath . "blograting/actions/rate.php");
	register_plugin_hook('cv:fields','cv', insert_toprate_entries);
?>