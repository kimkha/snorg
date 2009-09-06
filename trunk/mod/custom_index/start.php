<?php

	/**
	 * Elgg custom index page
	 * 
	 * @package ElggIndexCustom
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	 
    function indexCustom_init() {
	
        // Extend system CSS with our own styles
			extend_view('css','custom_index/css');
				
		// Replace the default index page
			register_plugin_hook('index','system','custom_index');
			
		// Add widget only for index page
			add_widget_type('index_blogs', elgg_echo('custom:blogs'), elgg_echo('custom:blogs:description'), 'index');
			add_widget_type('index_bookmarks', elgg_echo('custom:bookmarks'), elgg_echo('custom:bookmarks:description'), 'index');
			add_widget_type('index_groups', elgg_echo('custom:groups'), elgg_echo('custom:groups:description'), 'index');
			add_widget_type('index_files', elgg_echo('custom:files'), elgg_echo('custom:files:description'), 'index');
			add_widget_type('index_members', elgg_echo('custom:members'), elgg_echo('custom:members:description'), 'index');
			add_widget_type('index_login', elgg_echo('custom:login'), elgg_echo('custom:login:description'), 'index');
    }
    
    function custom_index() {
			
			if (!@include_once(dirname(__FILE__) . "/index.php")) return false;
			return true;
			
		}


    // Make sure the
		    register_elgg_event_handler('init','system','indexCustom_init');

?>