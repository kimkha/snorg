<?php
	/**
	 * Improve thewire plugin
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	/**
	 * Elgg thewire: add shout action
	 * 
	 * @package Elggthewire
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

	// Make sure we're logged in (send us to the front page if not)
		if (!isloggedin()) forward();

	// Get input data
		$body = get_input('note');
		$tags = get_input('thewiretags');
		$access_id = get_default_access();
		$location = get_input('location');
		$method = get_input('method');
		$parent = (int)get_input('parent', 0);
		if(!$parent)   
		    $parent = 0;
	
	// convert the shout body into tags
	    $tagarray = filter_string($body);
		
	// Make sure the title / description aren't blank
		if (empty($body)) {
			register_error(elgg_echo("thewire:blank"));
			forward("mod/thewire/add.php");
			
	// Otherwise, save the thewire post 
		} else {
			
			if (!thewire_save_post($body, $access_id, $parent, $method, $tagarray)) {
				register_error(elgg_echo("thewire:error"));
				if($location == "activity")
					forward("mod/riverdashboard/");
				else
					forward("mod/thewire/add.php");
			}
	        
	// Success message
			system_message(elgg_echo("thewire:posted"));
	
	// Forward 
			if($location == "activity")
					forward("mod/riverdashboard/");
			else
					forward("mod/thewire/everyone.php");
				
		}
		
?>