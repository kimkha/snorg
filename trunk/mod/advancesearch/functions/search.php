<?php

	/**
	 * Function for advancesearch
	 * 
	 * @package SNORG
	 * @author KimKha
	 */

/**
 * Merge two arrays with priority
 * 
 * @return int| new max score
 */
function merge_array_with_priority(&$main_array, $merged_array, $delta = 10) {
	if (!is_array($merged_array) || count($merged_array) <= 0) {
		return get_max_score_of_array($main_array, 1);
	}
	
	$score_max = get_max_score_of_array($main_array, $delta) + $delta;
	$merged_array = standard_for_array($merged_array);
	
	foreach ($main_array as $score => $array) {
		if (!is_array($array) || count($array) <=0) {
			unset($main_array[$score]);
			continue;
		}
		
		foreach ($array as $key => $value) {
			if (array_key_exists($key, $merged_array)) {
				$new_score = $score + $delta;
				$score_max = ($score_max<$new_score) ? $new_score : $score_max;
				
				if (isset($main_array[$new_score]) && is_array($main_array[$new_score]) && count($main_array[$new_score]) > 0) {
					$main_array[$new_score][$key] = $value;
				}
				else {
					$main_array[$new_score] = array ($key => $value);
				}
				
				unset($main_array[$score][$key]);
				unset($merged_array[$key]);
			}
		}
		
		if (!is_array($merged_array) || count($merged_array) <= 0) {
			break;
		}
	}
	
	if (is_array($merged_array) && count($merged_array) > 0) {
		if (!is_array($main_array[$delta]) || count($main_array[$delta]) <= 0) {
			$main_array[$delta] = $merged_array;
		}
		else {
			array_push($main_array[$delta], $merged_array);
		}
	}
	return $score_max;
}

/**
 * Find max score of array
 * 
 * @return int| max score
 */
function get_max_score_of_array($array, $delta) {
	$n = count($array);
	$max = 0;
	foreach ($array as $key => $value) {
		if ($key > $max) $max = $key;
	}
	
	return ($max - ($max%$delta));
}

/**
 * Standard for array to use advance search
 * 
 * @return array
 */
function standard_for_array($array) {
	$new = array();
	foreach ($array as $value) {
		$new[$value->guid] = $value;
	}
	return $new;
}


?>

