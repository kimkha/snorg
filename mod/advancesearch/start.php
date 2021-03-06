<?php

	/**
	 * Advance search
	 * Search users through them information
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	
	function advancesearch_init() {
		register_page_handler('advancesearch','advancesearch_page_handler');

	}
	
	function advancesearch_page_handler($page) {
		if (isset($page[0])) {
			if ($page[0] == 'result') {
				return advancesearch_result_handler(array_shift($page));
			}
			set_input('tag',$page[0]);
		}
		@include(dirname(__FILE__) . "/index.php");
		return true;
	}
	
	function advancesearch_result_handler($page) {
		if (isset($page[0]) && $page[0] != '') {
			set_input('tag',$page[0]);
		}
		@include(dirname(__FILE__) . '/functions/search.php');
		@include(dirname(__FILE__) . "/result.php");
		return true;
	}
	

	global $CONFIG;
//	register_action('muturalfriends/show', false, $CONFIG->pluginspath . 'muturalfriends/actions/show.php');
	register_elgg_event_handler('init','system','advancesearch_init');

?>