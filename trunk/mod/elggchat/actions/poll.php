<?php 
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Action to get all the information to form the ElggChat Toolbar
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

function splitname($name, $num) {
	if (strlen($name) > $num) return substr($name, 0, $num-1)."..";
	return $name;
}

if($user = get_loggedin_user()){
	$chat_sessions_count = get_entities_from_relationship(ELGGCHAT_MEMBER, $user->getGUID(), true, "", "", "", "time_created asc", null, null, true);
	$result = array();
	$currentTimestamp = get_input('currentTimestamp', 0);
	$newTimestamp = time();
	
	if($chat_sessions_count > 0){
		// Generate sessions
		$chat_sessions = $user->getEntitiesFromRelationship(ELGGCHAT_MEMBER, true);
		krsort($chat_sessions);
		
		$result["sessions"] = array();
		$result["timestamp"] = $newTimestamp;
		foreach($chat_sessions as $session){
			// Dont show session if not mine and no (non system) messages
			if(!(($session->owner_guid != $user->guid) && ($session->countAnnotations(ELGGCHAT_MESSAGE) == 0))){
				$result["sessions"][$session->guid] = array();
				
				// List all the Members of the chat session
				$members = $session->getEntitiesFromRelationship(ELGGCHAT_MEMBER);
				if(is_array($members) && count($members) > 1){
					
					$result["sessions"][$session->guid]["members"] = array();
					
					$firstMember = true;
					$member_count = count($members);
					
					foreach($members as $member){
						if($member->guid != $user->guid){
							if($firstMember){
								if($member_count > 2){
									$result["sessions"][$session->guid]["name"] = elgg_echo('elggchat:conference');
								} else {
									$result["sessions"][$session->guid]["name"] = splitname($member->name, 15);
								}
								$firstMember = false;
							}
							$result["sessions"][$session->guid]["members"][] = elgg_view("elggchat/user", array("chatuser" => $member));
						}
					}
				} else {
					$result["sessions"][$session->guid]["name"] = sprintf(elgg_echo("elggchat:session:name:default"), $session->guid);
				}
				
				// List all the messages in the session
				$msg_count = $session->countAnnotations();
				$result["sessions"][$session->guid]["message_count"] = $msg_count;
				
				if($msg_count > 0){
					$annotations = $session->getAnnotations("", $msg_count);
					$result["sessions"][$session->guid]["messages"] = array();
					
					foreach($annotations as $msg){
						if ($msg->time_created > $currentTimestamp)
							$result["sessions"][$session->guid]["messages"][$msg->id] = json_decode(elgg_view("elggchat/message", array("message" => $msg, "message_owner" => get_user($msg->owner_guid), "offset" => $msg->id)), true); 
					}
				}
			}
		}
	}
	
	// Add friends information
	$friends = $user->getEntitiesFromRelationship("friend",false,200);
	$result["friends_online_count"] = 0;
	if(is_array($friends) && count($friends) > 0){
		$result["friends"] = array();
		
		$inactive = (int) get_plugin_setting("onlinestatus_inactive", "elggchat");
		$time = time();
		foreach($friends as $friend){
			if($time - $friend->last_action <= $inactive){
				$result["friends_online_count"]++;
				$result["friends"][] = elgg_view("elggchat/user", array("chatuser" => $friend));
			}
			
		}
	}
	
	// Prepare to send nice JSON
	header("Content-Type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo json_encode($result);
}
exit();
?>