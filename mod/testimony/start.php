<?php

	/**
	 * Elgg Message board
	 * This plugin allows users and groups to attach a message board to their profile for other users
	 * to post comments and media.
	 *
	 * @todo allow users to attach media such as photos and videos as well as other resources such as bookmarked content
	 * 
	 * @package ElggMessageBoard
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	/**
	 * MessageBoard initialisation
	 *
	 * These parameters are required for the event API, but we won't use them:
	 * 
	 * @param unknown_type $event
	 * @param unknown_type $object_type
	 * @param unknown_type $object
	 */
	 
	 
	 
	function KeyName($myArray,$pos) {
  		/* uncomment the above line if you */
   		/* prefer position to start from 1 */

	   if ( ($pos < 0) || ( $pos >= count($myArray) ) )
	         return "NULL";  // set this any way you like
	
	   reset($myArray);
	   for($i = 0;$i < $pos; $i++) next($myArray);
	
	   return key($myArray);
	}
	
	
	
    function SelectTestimony(&$annotations, $owner)
    {
    	// If there is any content to view, view it
	
    	
    	//	echo "<pre>"; print_r($owner); die;    	
    	    $owner_guid = $owner->guid;   	    
    		
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
   
    	return 	$group_array;
    	
    	
		
		}	
	 
// funtcion update testimony at CV profile
	function cv($user) {
		
       	$contents = $user->getAnnotations('messageboard',5, 0, 'desc');
            
					
		$wall = elgg_echo("testimony:cv:latest").$user->name;
					
		foreach ( $contents as $content)
		{
						
				$wall .= '<div class="short-wall-post">';	
						
				$wall .=elgg_view("profile/icon",array('entity' => get_entity($content->owner_guid), 'size' => 'topbar'));
				$wall .= elgg_view("output/longtext",array("value" => parse_urls($content->value)));		
				$wall .= "</div>";
				
		}
					
					
		$annotations = $user->getAnnotations('messageboard',10000, 0, 'desc');
		//	echo "<pre>"; print_r($annotations);	
						
		//	echo "<pre>"; print_r("-------Group-----------------");
						
		$group_array =  SelectTestimony($annotations,$user);
		//	echo "<pre>"; print_r("	$group_array");
		//	echo "<pre>"; print_r("-------Friends---------------");
		//	echo "<pre>"; print_r($annotations); die;

	  	$wall .=  '<script type="text/javascript">
					$(function(){
							$("#tes_bygroup_collapse").hide();
							$("#tes_byfriend_collapse").hide();
					});
					function onclick_view_tes_bygroup() {
							
					      if ($("#tes_bygroup_collapse").is(":hidden")) {
					        $("#tes_bygroup_collapse").slideDown("slow");
					      } else {
					        $("#tes_bygroup_collapse").hide();
					      }
					};
					function onclick_view_tes_byfriend() {
							
					      if ($("#tes_byfriend_collapse").is(":hidden")) {
					        $("#tes_byfriend_collapse").slideDown("slow");
					      } else {
					        $("#tes_byfriend_collapse").hide();
					      }
					}
				</script>';
				
		if (count($group_array)>0)
		{
				$wall .= "<p><a id = \"view_tes_bygroup\" onClick=\"onclick_view_tes_bygroup();\"> View testimony about ".$user->name.' by group</a></p>';
				$wall .= "<div id=\"tes_bygroup_collapse\">";
	  			$pos = -1;
		  			
	  			foreach($group_array as $contents)
			    {
		  			$pos++;
		  				
					$wall .= "<div class=\"contentWrapper\">";
					$wall .= "<h2><b>Group: ".get_entity(KeyName($group_array,$pos))->name."</b></h2><br>";
				    $wall .= "<div class='group-wrapper'>";
		  			
			  		foreach($contents as $content)
					{
						$wall .= elgg_view("testimony/cv", array('annotation' => $content));
					}
							
					$wall .= "</div></div>";		
				}
							
					$wall .= "</div>";
				
	 	}
								
				
			
		if (count($annotations)>0)
		{							//	echo "<pre>"; print_r(count($annotations));
							//	echo "<pre>"; print_r($annotations); die;
					
				$wall .= '<p><a  id ="view_tes_byfriend" onClick="onclick_view_tes_byfriend();"> View testimony about '.$user->name.' by friends</a></p>';
					
				$wall .= "<div id=\"tes_byfriend_collapse\">";
						
				$wall .= "<div class=\"contentWrapper\">";
						
				$wall .= "<h2>Friends: </h2>";
				
				$wall .='<div class="group-wrapper">';		

				foreach ($annotations as $annotation)
				{
					$wall .= elgg_view("testimony/cv", array('annotation' =>$annotation));
				}
	  				
	  					
	  			$wall .= "</div></div>";
	  			$wall .= "</div>";
		}
    		
  		
		create_metadata($user->guid, 'TESTIMONY', $wall, 'text', $user->guid, ACCESS_PUBLIC);


}
	 
	 
 	function insert_testimony($hook, $type, $returnvalue, $params){
		$returnvalue['TESTIMONY'] = 'readonly';
		return $returnvalue;		
	}
	
    function messageboard_init() {
        
        // Load system configuration
			global $CONFIG;
				
        // Extend system CSS with our own styles, which are defined in the messageboard/css view
			extend_view('css','testimony/css');
		//
        // Register a page handler, so we can have nice URLs
			register_page_handler('testimony','testimony_page_handler');
        
	    // add a messageboard widget
            add_widget_type('testimony',"". elgg_echo("messageboard:board") . "","" . elgg_echo("messageboard:desc") . ".", "profile");
        
}
    
       
    /**
	 * Messageboard page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
		function testimony_page_handler($page) {
			
			global $CONFIG;
			
			// The username should be the file we're getting
			if (isset($page[0])) {
				set_input('username',$page[0]);
			}
			// Include the standard messageboard index
			include($CONFIG->pluginspath . "testimony/index.php");
			
		}
   

    // Make sure the shouts initialisation function is called on initialisation
		    register_elgg_event_handler('init','system','messageboard_init');
		    register_elgg_event_handler('pagesetup','system','messageboard_setup');

    // Register actions
		global $CONFIG;
		register_action("testimony/add",false,$CONFIG->pluginspath . "testimony/actions/add.php");
		register_action("testimony/delete",false,$CONFIG->pluginspath . "testimony/actions/delete.php");
		
		
		register_plugin_hook('cv:fields','cv', insert_testimony);
		
?>