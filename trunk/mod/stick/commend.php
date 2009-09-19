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
	
	if ($id != 0) {
		$entity = get_entity($id);
		
		$user = get_entity($entity->getOwner());
		
		$title = $entity->title;

		$block = elgg_view_entity($user);
		
		$header = elgg_view_title($title);
		
		$body = "<div id='view-commend'>{$entity->description}</div>";
		
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