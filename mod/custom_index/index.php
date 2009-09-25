<?php

	/**
	 * Rewrite to make it more intelligent
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	// Get the Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		/*
    //get required data		
	set_context('search');//display results in search mode, which is list view
	//grab the latest 4 blog posts. to display more, change 4 to something else
	$blogs = list_entities('object','blog',0,4,false, false, false);
	//grab the latest bookmarks
	$bookmarks = list_entities('object','bookmarks',0,4,false, false, false);
	//grab the latest files
	$files = list_entities('object','file',0,4,false, false, false);
	//get the newest members who have an avatar
	$newest_members = get_entities_from_metadata('icontime', '', 'user', '', 0, 10);
	//newest groups
	$groups = list_entities('group','',0,4,false, false, false);
	//grab the login form
	$login = elgg_view("account/forms/login");
	
    //display the contents in our new canvas layout
	$body = elgg_view_layout('new_index',$login, $files, $newest_members, $blogs, $groups, $bookmarks);
	/**/
	
//		set_page_owner(1);
	
	set_context('index');
	
	$main = "<div class='main-box'>".elgg_view("index/main")."</div>";
	$block = elgg_view("index/block");
	
	$body = elgg_view_layout('custom',$main,"",$main,"",$block);
	$body = '<div id="custom_index">'.$body.'</div>';
   /**/
    page_draw($title, $body);
		
?>