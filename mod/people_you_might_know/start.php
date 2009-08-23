<?php
	/**
	 * People you might know.
	 * 
	 * @package people_you_might_know
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Pedro Prez
	 * @copyright 2009
	 * @link http://www.pedroprez.com.ar/
 */

	require_once(dirname(__FILE__) . '/functions_people_you_might_know.php');
	
	function people_you_might_know_init()
	{
		global $CONFIG;
		
		// Register a page handler, so we can have nice URLs
	register_page_handler('peopleyoumightknow','people_you_might_know_page_handler');
		
		// Add generic new file widget
    add_widget_type('suggestfriend',elgg_echo("suggestfriend:title"),elgg_echo("suggestfriend:description"));
		
		// Extend CSS
				extend_view('css','people_you_might_know/css');

		if (get_context() == "friends" || 
		get_context() == "friendsof" ||
		get_context() == "collections") 
		{		
		// Extend the elgg topbar
				extend_view('owner_block/extend','people_you_might_know/owner_block');
		}
	}
	
	function people_you_might_know_pagesetup()
	{
		global $CONFIG;
		$page_owner = page_owner_entity();
		
		if (get_context() == "friends" || 
				get_context() == "friendsof" ||
				get_context() == "friendsoffriends" ||
				get_context() == "collections") 
		{
			if($page_owner->getGUID()==get_loggedin_userid())
				add_submenu_item(elgg_echo('peopleyoumightknow'),$CONFIG->wwwroot."pg/peopleyoumightknow/");
		}
		
		if (get_context() == "peopleyoumightknow")
		{
			add_submenu_item(elgg_echo('friends'),$CONFIG->wwwroot."pg/friends/" . page_owner_entity()->username);
			if(!$CONFIG->mod->friends_of_friends->config->hidefriendsof)
				add_submenu_item(elgg_echo('friends:of'),$CONFIG->wwwroot."pg/friendsof/" . page_owner_entity()->username);
			if($page_owner->getGUID()==get_loggedin_userid())
				add_submenu_item(elgg_echo('friendsoffriends'),$CONFIG->wwwroot."pg/friendsoffriends/" . page_owner_entity()->username);
		}
	}
	
	function people_you_might_know_page_handler($page) 
	{
		global $CONFIG;
    include($CONFIG->pluginspath . "people_you_might_know/index.php");  
	}
	
	register_elgg_event_handler('init','system','people_you_might_know_init');
	register_elgg_event_handler('pagesetup','system','people_you_might_know_pagesetup');
?>