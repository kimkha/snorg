<?php

	/**
	 * Add static page
	 * 
	 * @author KimKha
	 * @package Snorg
	 */

	global $CONFIG;
	$guid = (int) get_input("guid", 0);
	
	if ($guid == 0) { // New
		$obj = new ElggObject();
		$obj->subtype = 'expages';
	}
	else { // Edit
		$obj = get_entity($guid);
	}
	
	$title = get_input('title', '');
	$description = get_input('content', '');
	$parentid = (int) get_input('parent', 0);
	
	
	if (empty($title) || empty($description)) {
		register_error(elgg_echo("expages:blank"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	$parent = get_entity($parentid);
	if (!$parent && $parentid != 1) {
		register_error(elgg_echo('expages:invalidparent'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	$obj->title = $title;
	$obj->description = $description;
	$obj->owner_guid = $_SESSION['user']->getGUID();
	$obj->container_guid = $parentid;
	$obj->access_id = ACCESS_PUBLIC;
	
	if (!$obj->save()) {
		register_error(elgg_echo("expages:error"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	system_message(elgg_echo("expages:posted"));
	forward(expages_url()."read/".$obj->guid);
	
?>