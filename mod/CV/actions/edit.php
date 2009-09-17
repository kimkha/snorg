<?php

	/**
	 * Elgg profile plugin edit action
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
		
	// Load configuration
		global $CONFIG;

	// Get profile fields
		$input = array();
		$accesslevel = get_input('accesslevel');
		if (!is_array($accesslevel)) $accesslevel = array();
		
		foreach($CONFIG->cv as $lable => $valuetype) {
			$tmp = str_replace(" ", "______", $lable);
			$input[$lable] = get_input($tmp);
			//print_r($lable . ' ' .$value); die;
			if ($valuetype == 'tags')
				$input[$lable] = string_to_tag_array($input[$lable]);
		}
		
	// Save stuff if we can, and forward to the user's profile
		
		if ($user = page_owner()) {
			$user = page_owner_entity();			
		} else {
			$user = $_SESSION['user'];
			set_page_owner($user->getGUID());
		}
		if ($user->canEdit()) {
			
			// Save stuff
			if (sizeof($input) > 0)
				foreach($input as $lable => $value) {
					
					//$user->$shortname = $value;
					remove_metadata($user->guid, $lable);
					if (isset($accesslevel[$tmp])) {
						$access_id = (int) $accesslevel[$tmp];
					} else {
						// this should never be executed since the access level should always be set
						$access_id = ACCESS_PRIVATE;
					}
					if (is_array($value)) {
						
						$i = 0;
						foreach($value as $interval) {
							$i++;
							if ($i == 1) { $multiple = false; } else { $multiple = true; }
							print_r($lable);die;
							create_metadata($user->guid, $lable, $interval, 'text', $user->guid, $access_id, $multiple);
						}
					} else {
						
						create_metadata($user->guid, $lable, $value, 'text', $user->guid, $access_id);
					}
					
				}
			$user->save();

			// Notify of profile update
			trigger_elgg_event('cvupdate',$user->type,$user);
			
			//add to river
			add_to_river('river/user/default/cvupdate','update',$_SESSION['user']->guid,$_SESSION['user']->guid);
			
			system_message(elgg_echo("cv:saved"));
			
			// Forward to the user's profile
			forward($user->getUrl());

		} else {
	// If we can't, display an error
			
			system_message(elgg_echo("cv:cantedit"));
		}

?>