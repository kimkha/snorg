<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	if (isadminloggedin()) {
		$owner = get_loggedin_userid();
		set_page_owner($owner);
	} else {
		set_page_owner(1);
	}
	
	// get album entities
	
	set_context('index');
	
	$main = "<div class='main-box'>".elgg_view("stick/album")."</div>";
	$block = elgg_view("index/block");
	
	$title = "Common Gallery";
	$body = elgg_view_layout('widgets',$main,"",$main,"",$block);
	$body = '<div id="custom_index">'.$body.'</div>';
   /**/
    page_draw($title, $body);
	
?>