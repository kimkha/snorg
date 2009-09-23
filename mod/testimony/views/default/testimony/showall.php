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
	 
	 	$owner = get_entity(page_owner());
  	
	  	if (is_array($vars['annotation']) && sizeof($vars['annotation']) > 0) {
			
		   $annotations = $vars['annotation'];	
			
		   $group_array =  SelectTestimony($annotations,$owner);
    		 		

	  
	  
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
					echo elgg_view("testimony/showtestimony", array('annotation' => $content));
					}
					
				echo "</div></div>";		
			}		

			if ( count($annotations)>0)
			{
					
				echo "<div class=\"contentWrapper\">";
				echo "<h2>Friends: </h2>";
				echo "<div class='group-wrapper'>";
			
			//	echo "Friend";
				foreach ($annotations as $annotation )
				
				echo elgg_view("testimony/showtestimony", array('annotation' =>$annotation));
	  
				echo "</div></div>";
			}
    
    		
    
			
		} else {
    		
    		echo "<div class='contentWrapper'>" . elgg_echo("messageboard:none") . "</div>";
    		
		}
			
	 
?>