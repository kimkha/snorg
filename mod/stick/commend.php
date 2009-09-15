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
	
	$id = (int) get_input("id", 0);
	$entity = get_entity($id);
	
	$user = get_entity($entity->getOwner());
	
	$title = $entity->title;
	
	$block = elgg_view_entity($user);
	
	$header = elgg_view_title($title);
	
	$body = "<div id='view-commend'>{$entity->description}</div>";
	
	$content = elgg_view_layout("two_column_left_sidebar", $block, $header.$body);
	
	page_draw($title,$content);
?>