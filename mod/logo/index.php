<?php
	/**
	 * Elgg file browser
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * 
	 * TODO: File icons, download & mime types
	 */

	
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

		if(isadminloggedin()){
			
			$area2 = elgg_view_title($title = elgg_echo('logo:home'));
		

	// Get objects
		set_context('search');
		$area2 .= list_entities("object",'logo',null,1000);
	//	echo "<pre>"; print_r($k); die;
		$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);
	
	// Finally draw the page
		page_draw(sprintf(elgg_echo('logo:home'),page_owner_entity()->name), $body);
		}
?>