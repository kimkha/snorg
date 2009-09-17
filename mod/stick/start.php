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
	
	define("_STICK_BLOG_RELATIONSHIP_", "stickedblog_");
	define("_STICK_PHOTO_RELATIONSHIP_", "sticked_photo");
	define("_STICK_COMMEND_SUBTYPE_", "commend");
	
	function stick_init() {
		// Register homepage
		extend_view("css", "stick/css", 600);
		extend_view("index/main", "stick/homepage", 450);
		extend_view("index/block", "stick/commend", 400);
		extend_view("js/initialise_elgg", "stick/js");
		
		// Page handler for blogspot
		register_page_handler("stick", "stick_page");
		
		// Register subtype
		register_entity_type('object',_STICK_COMMEND_SUBTYPE_);
	}
	
	function stick_pagesetup() {
		global $CONFIG;
		
		if (!isadminloggedin()) return false;
		
		// Insert menu to blogspot
		if (get_context() == "blog") {
			$post = (int) get_input('blogpost');
			if ($blogpost = get_entity($post)) {
				
				$category = get_plugin_setting("blogcategory", "stick");
				$array = explode(",", $category);
				$subrelationship = convert_whitespace_array($array);
				
				$object = check_entity_multi_relationship(1, _STICK_BLOG_RELATIONSHIP_, $blogpost->getGUID(), $subrelationship);
				// If this blogspot is not sticked
				if (!$object) {
					add_submenu_item(elgg_echo('stick:postit'), $CONFIG->wwwroot."action/stick/add?id=".$blogpost->getGUID(), "_admin", "stick_choose_category(this)");
				}
				else {
					add_submenu_item(elgg_echo('stick:removeit'), $CONFIG->wwwroot."action/stick/remove?id=".$object->id, "_admin");
				}
				
			}
		}
		
		// Insert submenu into photo view
		if (get_context() == "photos" && is_included($CONFIG->path."mod/tidypics/viewimage.php")) {
			$photo = (int) get_input('guid');
			$object = check_entity_relationship(1, _STICK_PHOTO_RELATIONSHIP_, $photo);
			
			if (!$object) {
				add_submenu_item(elgg_echo('stick:ipostit'), $CONFIG->wwwroot."action/stick/addphoto?id=".$photo, "_admin");
			}
			else {
				add_submenu_item(elgg_echo('stick:iremoveit'), $CONFIG->wwwroot."action/stick/remove?id=".$object->id, "_admin");
			}
		}
		
		// Insert submenu into user profile
		extend_view('profile/menu/links','stick/menuadd', 400);
		extend_view('profile/menu/linksownpage','stick/menuadd', 400);
	}
	
	function stick_page($page) {
		switch ($page[0]) {
			case "blog":
				@include(dirname(__FILE__) . "/index_blog.php");
				return true;
			case "album":
				@include(dirname(__FILE__) . "/index_album.php");
				return true;
			case "commend":
				@include(dirname(__FILE__) . "/commend.php");
				return true;
			default:
				break;
		}
		return false;
	}
	
	register_elgg_event_handler('init','system','stick_init');
	register_elgg_event_handler('pagesetup','system','stick_pagesetup');
	
	// Register actions
	global $CONFIG;
	register_action("stick/add",false,$CONFIG->pluginspath . "stick/actions/add.php", true);
	register_action("stick/remove",false,$CONFIG->pluginspath . "stick/actions/remove.php", true);
	register_action("stick/addphoto",false,$CONFIG->pluginspath . "stick/actions/addphoto.php", true);
	register_action("stick/removephoto",false,$CONFIG->pluginspath . "stick/actions/removephoto.php", true);
	register_action("stick/commend",false,$CONFIG->pluginspath . "stick/actions/commend.php", true);
	register_action("stick/uncommend",false,$CONFIG->pluginspath . "stick/actions/uncommend.php", true);
	register_action("stick/editcommend",false,$CONFIG->pluginspath . "stick/actions/editcommend.php", true);
	register_action("stick/updatecommend",false,$CONFIG->pluginspath . "stick/actions/updatecommend.php", true);
	register_action("stick/blog",false,$CONFIG->pluginspath . "stick/actions/blog.php");
	
?>