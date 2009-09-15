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
	
	$userId = (int) get_input('userid');
	$user = get_entity($userId);
	
	$title = "Commend ".$user->name;
	$header = elgg_view_title($title);
	
	$block = elgg_view_entity($user);
	
	$body = elgg_view("stick/forms/commend", array("userid" => $userId));
	
	$content = elgg_view_layout("two_column_left_sidebar", $block, $header.$body);
	
	page_draw($title,$content);
	exit();
?>