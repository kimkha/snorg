<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	define("_STICK_BLOG_RELATIONSHIP_", "sticked_blog");
	
	function stick_init() {
		// Register homepage
		extend_view("css", "stick/css", 600);
		extend_view("index/main", "stick/homepage", 450);
	}
	
	function stick_pagesetup() {
		global $CONFIG;
		
		// Insert menu to blogspot
		if (get_context() == "blog" && isadminloggedin()) {
			$post = (int) get_input('blogpost');
			if ($blogpost = get_entity($post)) {
				
				// If this blogspot is not sticked
				if (!check_entity_relationship(1, _STICK_BLOG_RELATIONSHIP_, $blogpost->getGUID())) {
					add_submenu_item(elgg_echo('stick:postit'), $CONFIG->wwwroot."action/stick/add?id=".$blogpost->getGUID(), "_admin");
				}
				else {
					add_submenu_item(elgg_echo('stick:removeit'), $CONFIG->wwwroot."action/stick/remove?id=".$blogpost->getGUID(), "_admin");
				}
				
			}
		}
		
	}
	
	register_elgg_event_handler('init','system','stick_init');
	register_elgg_event_handler('pagesetup','system','stick_pagesetup');
	
	// Register actions
	global $CONFIG;
	register_action("stick/add",false,$CONFIG->pluginspath . "stick/actions/add.php", true);
	register_action("stick/remove",false,$CONFIG->pluginspath . "stick/actions/remove.php", true);
	
?>