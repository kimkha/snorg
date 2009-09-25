<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	global $CONFIG;
	$id = (int) get_input("id", 0);
	
	if ($id != 0) {
		$entity = get_entity($id);
		
		if (isadminloggedin()) {
			add_submenu_item(elgg_echo('stick:user:edit'), $CONFIG->wwwroot."action/stick/editcommend?id=".$id, "_admin");
			add_submenu_item(elgg_echo('stick:uremoveit'), $CONFIG->wwwroot."action/stick/uncommend?id=".$id, "_admin");
		}
		
		$user = get_entity($entity->getOwner());
		
		$title = $entity->title;

		$block = elgg_view_entity($user);
		
		$header = elgg_view_title($title);
		
		$body = "<div id='view-commend' class='contentWrapper singleview'>{$entity->description}</div>";
		$body .= elgg_view_comments($entity);
		
		$content = elgg_view_layout("two_column_left_sidebar", $block, $header.$body);
	}
	else {
		set_context('index');
		
		$title = elgg_echo('stick:user:viewall');
		$header = elgg_view_title($title);
		
		$main = "<div class='main-box'>".$header.elgg_view("stick/allcommend")."</div>";
		$block = elgg_view("index/block");
		
		$body = elgg_view_layout('widgets',$main,"",$main,"",$block);
		$content = '<div id="custom_index">'.$body.'</div>';
	}
	
	page_draw($title,$content);
?>