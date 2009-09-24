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

if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0) {
	$alltag = array();
	foreach ($vars['config']->profile as $item) {
		$alltag = array_merge($item, $alltag);
	}
	
	unset($alltag['description']);
	unset($alltag['birthday']);
	
	$result_array = array();
	$max_score = 0;
	$output = '';
	
	foreach($alltag as $shortname => $valtype) {
		$form_value = get_input($shortname, '');
		if ($form_value != '') {
			$output .= elgg_echo("profile:{$shortname}").": <b>".$form_value."</b>, ";
			$value = '';
			$form_value = get_input($shortname);
			
			if ($entity = get_entities_from_metadata($shortname, $form_value)) {
				if (is_array($entity)) {
					$max_score = merge_array_with_priority($result_array, $entity);
				}
				else {
					continue;
				}
			}
		}
	}
	
	krsort($result_array);
	$arr_merge = $result_array[$max_score];
	unset($result_array[$max_score]);
	
	foreach ($result_array as $keys => $items) {
		foreach ($items as $k => $i) {
			array_push($arr_merge, $i);
			unset($result_array[$keys][$k]);
		}
		unset($result_array[$keys]);
	}
	
	$count = count($arr_merge);
	echo "<div class=\"contentWrapper\">".elgg_echo('advancesearch:multiresult');
	echo $output;
	echo "</div>";
	echo elgg_view_entity_list($arr_merge, $count, $offset, $count);
}


?>

