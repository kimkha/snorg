<?php
	/**
	* Notebook
	* 
	* All the Notebook CSS can be found here
	* 
	* @package SNORG
	* @author KimKha
	*/
	
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();
	
	$title = elgg_view_title(elgg_echo('notebook:title'));
	$list = elgg_view('notebook/list');

	$page_data = $title . $list;

	// Display main admin menu
	page_draw(elgg_echo('elggchat'), elgg_view_layout("two_column_left_sidebar", '', $page_data));
?>
