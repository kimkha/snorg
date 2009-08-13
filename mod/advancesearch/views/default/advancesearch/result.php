<?php

	/**
	 * Elgg hoverover extender for blog
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

$offset = get_input('offset', 0);
$searchbytype = get_input('searchbytype', 'multiresult');

$baseurl = preg_replace('/[\&\?]searchbytype\=[A-Za-z0-9]*/',"",$vars['baseurl']);
if (substr_count($baseurl,'?')) {
	$baseurl .= "&searchbytype=";
} else {
	$baseurl .= "?searchbytype=";
}

if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0) {
	$alltag = $vars['config']->profile;
	unset($alltag['description']);
	
	# set menu
	add_submenu_item(elgg_echo("advancesearch:menu:multiresult"), $baseurl.'multiresult', 'result');
	foreach ($alltag as $shortname => $valtype) {
		$form_value = get_input($shortname);
		if ($form_value != '') {
			add_submenu_item(elgg_echo("advancesearch:menu:{$shortname}"), $baseurl.$shortname, 'result');
		}
	}

	$value = "djdjdj".$vars['baseurl']."<div class=\"contentWrapper\">".elgg_echo('advancesearch:multiresult');
	$meta_array = array();
	foreach ($alltag as $shortname => $valtype) {
		$form_value = get_input($shortname);
		if ($form_value != '') {
			$value .= elgg_echo("profile:{$shortname}").": <b>".$form_value."</b>, ";
		}
		$meta_array[$shortname] = $form_value;
	}
	$value .= "</div>";
	echo $value;
	
	if ($entity = get_entities_from_metadata_multi($meta_array)) {
		if (is_array($entity)) {
			$count = count($entity);
			# "Change listing type" => /view/default/search/entity_list.php
			echo elgg_view_entity_list($entity, $count, $offset, $count);
		}
	}
	
	foreach($alltag as $shortname => $valtype) {
		if (get_input($shortname, '') != '') {
			$value = '';
			$form_value = get_input($shortname);
			
			if ($entity = get_entities_from_metadata($shortname, $form_value)) {
				if (is_array($entity)) {
					$count = count($entity);
					# "Change listing type" => /view/default/search/entity_list.php
					$value .= elgg_view_entity_list($entity, $count, $offset, $count);
				}
				else {
					continue;
				}
			}
			
			echo "<div class=\"contentWrapper\">";
			echo elgg_echo("advancesearch:{$shortname}").": <b>".$form_value;
			echo "</b></div>";
			echo $value;
		}
	}
}


?>

