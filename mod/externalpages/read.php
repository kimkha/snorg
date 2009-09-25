<?php

	/**
	 * Add static page
	 * 
	 * @author KimKha
	 * @package Snorg
	 */

	/**
	 * Elgg read external page
	 * 
	 * @package ElggExpages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	// Load Elgg engine
		define('externalpage',true);
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// set some variables
		$type = get_input('expages');
		
		set_context("index");
		
	if (is_numeric($type)) {
		
		$entity = get_entity($type);
		
		$area1 = elgg_view_title($entity->title);
		$area1 .= elgg_view('page_elements/contentwrapper',array('body' => $entity->description));
		
		if (isadminloggedin()) {
			$area1 .= "<a href='".expages_url("?act=edit&id=".$entity->guid)."'>".elgg_echo("edit")."</a>";
			$area1 .= " <a href='".expages_url("?act=delete&id=".$entity->guid)."'>".elgg_echo("delete")."</a>";
		}
	}
	else {
	// Set the title appropriately
		$area1 = elgg_view_title(elgg_echo($type));
		
		//get contents
		$contents = get_entities("object", $type, 0, "", 1);
		
		if($contents){
			foreach($contents as $c){
				$area1 .= elgg_view('page_elements/contentwrapper',array('body' => $c->description));
			}
		}else
			$area1 .= elgg_view('page_elements/contentwrapper',array('body' => elgg_echo("expages:notset")));
	}
											

	// View it
		$main = "<div class='main-box'>".$area1."</div>";
		$block = elgg_view("index/block");
		
		$body = elgg_view_layout('widgets',$main,"",$main,"",$block);
		
		page_draw($title,$body);
		
?>