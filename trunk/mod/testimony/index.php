<?php

    /**
	 * Elgg Message board index page
	 * 
	 * @package ElggMessageBoard
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	// set_context("showall");
	
	
	 // Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
	// Get the user who is the owner of the message board
	    $entity = get_entity(page_owner());
	    
    // Get any annotations for their message board
		$contents = $entity->getAnnotations('messageboard', 1000, 0, 'desc');
	
    // Get the content to display
        $area2 = elgg_view_title(elgg_echo('messageboard:board'));
    
    // only display the add form and board to logged in users
    	if(isloggedin()){
    		
   			$area2 .= elgg_view("testimony/forms/add");
			$area2 .= elgg_view("testimony/showall", array('annotation' => $contents));
    		
    	
		}
		
     //select the correct canvas area
	    $body = elgg_view_layout("two_column_left_sidebar", '', $area2);
		
	// Display page
		page_draw(sprintf(elgg_echo('messageboard:user'),$entity->name),$body);
	 
?>