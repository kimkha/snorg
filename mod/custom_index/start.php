<?php

	/**
	 * Rewrite to make it more intelligent
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	 
    function indexCustom_init() {
	
        // Extend system CSS with our own styles
			extend_view('css','custom_index/css');
			
	//		extend_view('index/main','custom_index/main', 450);
			extend_view('index/block','custom_index/login', 450);
				
		// Replace the default index page
			register_plugin_hook('index','system','custom_index');
			
		// Add widget only for index page
			add_widget_type('index_blogs', elgg_echo('custom:blogs'), elgg_echo('custom:blogs:description'), 'index');
			add_widget_type('index_bookmarks', elgg_echo('custom:bookmarks'), elgg_echo('custom:bookmarks:description'), 'index');
			add_widget_type('index_groups', elgg_echo('custom:groups'), elgg_echo('custom:groups:description'), 'index');
			add_widget_type('index_files', elgg_echo('custom:files'), elgg_echo('custom:files:description'), 'index');
			add_widget_type('index_members', elgg_echo('custom:members'), elgg_echo('custom:members:description'), 'index');
    }
    
    function custom_index() {
			
			if (!@include_once(dirname(__FILE__) . "/index.php")) return false;
			return true;
			
		}


    // Make sure the
		    register_elgg_event_handler('init','system','indexCustom_init');

?>