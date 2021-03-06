<?php 

	/**
	 * Edit to make chat intelligently
	 * 
	 * @author KimKha
	 * @package Snorg
	 */
	 
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Nice display of an User for display in Friendspicker and Chat Members
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/
	
$user = $vars["chatuser"];

if(!empty($user) && $user instanceof ElggUser){
	$link = $vars["link"];
	$icon = $vars["icon"];
	$onlineStatus = $vars["onlineStatus"];
	
	if($link !== false || $link !== true){
		$link = true;
	}
	
	if($icon !== false || $icon !== true){
		$icon = true;
	}
	
	if($onlineStatus !== false || $onlineStatus !== true){
		$onlineStatus = true;
	}
	
	$iconSize = "tiny";
	
	$result = "";
	
	$result .= "<tr class='chatmember'>";
	
	if($icon){
		$result .= "<td><img src='" . $user->getIcon($iconSize) . "' alt='" . $user->name . "' /></td>";
	 }
	
	if($link){
			$result .= "<td class='chatmemberinfo'><a href='" . $user->getUrl() . "' title='" . $user->name . "' rel='" . $user->guid . "'>" . splitname($user->name, 20) . "</a></td>";
	} else { 
			$result .= "<td class='chatmemberinfo'>". splitname($user->name, 20) . "</td>";
	}
	
	if($onlineStatus){
		$diff = time() - $user->last_action;
		
		$inactive = (int) get_plugin_setting("onlinestatus_inactive", "elggchat");
		if (!$inactive) $inactive = 600;
		$active = (int) get_plugin_setting("onlinestatus_active", "elggchat");
		if (!$active) $active = 60;
		
		$title = sprintf(elgg_echo("elggchat:session:onlinestatus"), friendly_time($user->last_action));
		
		if($diff <= $active){
			$result .= "<td><div class='online_status' title='" . $title . "'></div></td>";
		}elseif($diff <= $inactive){
			$result .= "<td><div class='online_status online_status_idle' title='" . $title . "'></div></td>";
		}else{
			$result .= "<td><div class='online_status online_status_inactive' title='" . $title . "'></div></td>";
		}
	}
	
	$result .= "</tr>";
	
	echo $result;
}
?>