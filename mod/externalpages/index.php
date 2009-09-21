<?php
	/**
	 * Elgg External pages
	 * 
	 * @package ElggExpages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();
	set_context('admin');
	
	// Set admin user for user block
	set_page_owner($_SESSION['guid']);
	
	if (get_input("act") == 'new') {
		$type = "expages";
		$edit = elgg_view('expages/forms/editpage');
		$body = elgg_view('page_elements/contentwrapper',array('body' => $edit));
	}
	else if (get_input("act") == 'edit' && ($id = (int) get_input("id",0)) != 0) {
		$type = "expages";
		$entity = get_entity($id);
		$edit = elgg_view('expages/forms/editpage', array('entity'=>$entity));
		$body = elgg_view('page_elements/contentwrapper',array('body' => $edit));
	}
	else if (get_input("act") == 'delete' && ($id = (int) get_input("id",0)) != 0) {
		$entity = get_entity($id);
		$entity->delete();
		system_message(elgg_echo("expages:deleted"));
		forward();
	}
	else {
		$type = get_input('type'); //the type of page e.g about, terms etc
		if(!$type)
			$type = "front"; //default to the frontpage
		
		// Display the correct form
		if($type == "front")
			$edit = elgg_view('expages/forms/editfront');
		else
			$edit = elgg_view('expages/forms/edit', array('type' => $type));
		
		// Display the menu
		$body = elgg_view('page_elements/contentwrapper',array('body' => elgg_view('expages/menu', array('type' => $type)).$edit));
	}
	
	//display the title
	$title = elgg_view_title(elgg_echo('expages'));
	
	
	$block = elgg_view("expages/sidebar");
		
	// Display
	page_draw(elgg_echo('expages'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
?>