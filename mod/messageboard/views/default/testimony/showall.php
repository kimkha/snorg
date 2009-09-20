<?php

    /**
	 * Elgg Message board display page
	 * 
	 * @package ElggMessageBoard
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	 
	 
	 //set_context($view_testimony);
	 
	 
	 
	 
	 function KeyName($myArray,$pos) {
  		 // $pos--;
   		/* uncomment the above line if you */
   		/* prefer position to start from 1 */

	   if ( ($pos < 0) || ( $pos >= count($myArray) ) )
	         return "NULL";  // set this any way you like
	
	   reset($myArray);
	   for($i = 0;$i < $pos; $i++) next($myArray);
	
	   return key($myArray);
	}

	 

	 // If there is any content to view, view it
		if (is_array($vars['annotation']) && sizeof($vars['annotation']) > 0) {
    		
    		$owner = get_entity(page_owner());
    	//	echo "<pre>"; print_r($owner); die;
    	
    	    $owner_guid = $owner->guid;
    	    
    		$annotations = $vars['annotation'];
    		//echo "<pre>"; print_r($annotations); die;
    		
    		$list_group = get_entities_from_relationship('member',$owner_guid,false);
    	//	echo "<pre>"; print_r($list_group); die;
    		
    		$group_array = array();
    		
   			foreach($list_group as $group)
    		{
    			//echo "<pre>"; print_r($list_group); die;
    			$group_array[$group->guid]=null;
    		}
    
    		$i = -1;
   			$j=-1;
    		
    		// array to store where is the key of position which will be delete
    		$saveposition = array();
    			 		
    		//to save annotation to array which is divide by group id
    		   			
    			foreach($list_group as $group)
	    		{
	    			$list_member = get_group_members($group->guid,1000);
	    			$temp = array();
	    			
	    			foreach ($annotations as $annotation)
    				{
    					$i++;
	    		
		    			foreach ($list_member as $member)
		    			{
		    				
		    				if( $member->guid == $annotation->owner_guid )
		    				{
		    						
		    						$temp[]= $annotation;
		    						$saveposition[] = $i;
		    				}
		    			}
    				}
	    			//echo "<pre>"; print_r($temp);die;
	    			$group_array[$group->guid] = $temp;
	    		}
    		
    		
    	
    		//	echo "<pre>"; print_r($group_array);die;
    		foreach($saveposition as $position )
    		{
    			unset($annotations[$position]);
    		}
    		
    		
    //	echo "<pre>"; print_r($vars['annotation']);
    //		echo "<pre>"; print_r($annotations);die;
    			
 			
  		$pos = -1;
  		 
			
  		
  		foreach($group_array as $contents) {
  			$pos++;
  				
			echo "<div class=\"contentWrapper\">";
			echo "<h2><b>Group: ".get_entity(KeyName($group_array,$pos))->name."</b></h2><br>";
		    echo "<div class='group-wrapper'>";
		
  			//echo get_entity(key($contents))
  		//	echo get_entity(KeyName($group_array,$pos))->name;
  			
  			foreach($contents as $content)
				{
				echo elgg_view("testimony/group", array('annotation' => $content));
				}
				
			echo "</div></div>";		
		}		

		if ( count($annotations)>0)
		{
				
			echo "<div class=\"contentWrapper\">";
			echo "<h2>Friends: </h2>";
		
		//	echo "Friend";
			foreach ($annotations as $annotation )
			
			echo elgg_view("testimoy/friend", array('annotation' =>$annotation));
  
			
		}
    
    		
    
    		
    		//start the div which will wrap all the message board contents
    
    		//loop through all annotations and display
		//	foreach($vars['annotation'] as $content) {
				
				//echo elgg_view("messageboard/messageboard_content", array('annotation' => $content));
				
			//}
			
			//close the wrapper div
		//	echo "</div>";
			
		} else {
    		
    		echo "<div class='contentWrapper'>" . elgg_echo("messageboard:none") . "</div>";
    		
		}
			
	 
?>