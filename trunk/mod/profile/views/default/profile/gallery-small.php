<?php

	/**
	 * Elgg user display (gallery)
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] The user entity
	 */
	 
	    //grab the users status message with metadata 'state' set to current if it exists
/*		if($get_status = get_entities_from_metadata("state", "current", "object", "status", $vars['entity']->guid)){
    		    
            foreach($get_status as $s) {
	            $info = elgg_view("status/friends_view", array('entity' => $s));
            }
    		    
		} */

		$icon = elgg_view(
				"profile/icon", array(
										'entity' => $vars['entity'],
										'size' => 'small',
									  )
			);
			
		$banned = $vars['entity']->isBanned();
	
		$rel = "";
		if (page_owner() == $vars['entity']->guid)
			$rel = 'me';
		else if (check_entity_relationship(page_owner(), 'friend', $vars['entity']->guid))
			$rel = 'friend';
			
		$name = $vars['entity']->name;
			
		if (preg_match('/[^a-zA-Z0-9\.\-\_]/',$name)) {//contains non-letter char
			if (strlen($name)>9) {				
				$name = substr($name,0,9);
			}			
		}elseif (strlen($name)>4){
			$name = substr($name,0,4);
		}		
		
		if (!$banned)
			$info .= "<span><b><a href=\"" . $vars['entity']->getUrl() . "\" rel=\"$rel\">" . $name . "</a></b></span>";
		else
			$info .= "<span><b><strike>" . $name . "</b></strike><br />".elgg_echo('profile:banned')."</span>";
		
		// echo elgg_view_listing($icon, $info);
		echo $icon.$info;
			
?>