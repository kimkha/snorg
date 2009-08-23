<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Main initialization file
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/
	global $CONFIG;
	
	function notebook_init() {
		if(isloggedin()){
//			if(get_plugin_usersetting("enableChat") != "no"){
				// Extend system CSS with our own styles
				extend_view('css','notebook/css');
				
		//		extend_view('profile/menu/actions', 'elggchat/profile_menu_actions');
				
				// JS in cache
				extend_view("js/initialise_elgg", "notebook/js");
//			}
		}
    }
	
	register_elgg_event_handler('init', 'system', 'notebook_init');
	
	// actions
	register_action("notebook/create", false, $CONFIG->pluginspath . "notebook/actions/create.php");

?>