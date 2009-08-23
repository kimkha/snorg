<?php
	/**
	* Notebook
	* 
	* All the Notebook CSS can be found here
	* 
	* @package notebook
	* @author KimKha
	*/
	
	global $CONFIG;
	
	define('NOTEBOOK_SUBTYPE', 'notebook');
	define('NOTEBOOK_RELATIONSHIP', 'notebookOf');
	define('NOTEBOOK_TITLE', 'title');
	define('NOTEBOOK_DESCRIPTION', 'description');
	define('NOTEBOOK_CATEGORY', 'category');
	define('NOTEBOOK_COMMENT', 'comment');
	
	function notebook_init() {
		if(isloggedin()){
				// Extend system CSS with our own styles
				extend_view('css','notebook/css');
				
				// Extand on taskbar
				extend_view('taskbar/extend', 'notebook/taskbar', 500);
				
				// JS in cache
				extend_view("js/initialise_elgg", "notebook/js");
		}
    }
	
	register_elgg_event_handler('init', 'system', 'notebook_init');
	
	// actions
	register_action("notebook/create", false, $CONFIG->pluginspath . "notebook/actions/create.php");
	register_action("notebook/load", false, $CONFIG->pluginspath . "notebook/actions/load.php");

?>