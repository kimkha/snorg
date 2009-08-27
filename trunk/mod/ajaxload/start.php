<?php

	/**
	 * Ajax load pages
	 * 
	 * User don't need load fullpage to view
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @link http://elgg.org/
	 */
	
	function ajaxload_init() {
//		global $CONFIG; forward();
		//print_r($_SERVER);die;
		
		extend_view("js/initialise_elgg", 'ajaxload/js');
	}
	
	function ajaxload_pagesetup() {
	//	print_r($vars);die;
	}
	
	register_elgg_event_handler('pagesetup','system','ajaxload_pagesetup');
	register_elgg_event_handler('init','system','ajaxload_init');

?>