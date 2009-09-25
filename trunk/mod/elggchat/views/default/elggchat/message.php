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
	* Nice display of a chat message for in the chat windows
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/
	
	$message = $vars['message'];
	$offset = $vars['offset'];
	$user = $vars['message_owner'];
	$smiley_url = $vars['url'] . "action/elggchat/get_smiley?_" . time() . "&smiley=";
	
	$randomint = time();
	$smileys = array(
		":(|)" => "<img src='" . $smiley_url . "animated_smileys/monkey.gif'>",
		"=D" => "<img src='" . $smiley_url . "animated_smileys/smile.gif'>",
		"=)" => "<img src='" . $smiley_url . "animated_smileys/smile.gif'>",
		":)" => "<img src='" . $smiley_url . "animated_smileys/smile.gif'>",
		";)" => "<img src='" . $smiley_url . "animated_smileys/wink.gif'>",
		":(" => "<img src='" . $smiley_url . "animated_smileys/frown.gif'>",
		":D" => "<img src='" . $smiley_url . "animated_smileys/grin.gif'>",
		"x-(" => "<img src='" . $smiley_url . "animated_smileys/angry.gif'>",
		"B-)" => "<img src='" . $smiley_url . "animated_smileys/cool.gif'>",
		":'(" => "<img src='" . $smiley_url . "animated_smileys/cry.gif'>",
		"\m/" => "<img src='" . $smiley_url . "animated_smileys/rockout.gif'>",
		":-o" => "<img src='" . $smiley_url . "animated_smileys/shocked.gif'>",
		":-/" => "<img src='" . $smiley_url . "animated_smileys/slant.gif'>",
		":-|" => "<img src='" . $smiley_url . "animated_smileys/straightface.gif'>",
		":P" => "<img src='" . $smiley_url . "animated_smileys/tongue.gif'>",
		":-D" => "<img src='" . $smiley_url . "animated_smileys/nose_grin.gif'>",
		";-)" => "<img src='" . $smiley_url . "animated_smileys/wink_nose.gif'>",
		";^)" => "<img src='" . $smiley_url . "animated_smileys/wink_big_nose.gif'>",
		
		);
	
	if($message->access_id != ACCESS_PRIVATE || $user->guid == get_loggedin_userid()){
		$result = array();
		if($message->name == ELGGCHAT_MESSAGE){
			$result['offset']	= $offset;
			$result['guid'] 	= $user->guid;
			$result['time'] 	= date("h:i A", $message->time_created-(60*60));
			$result['name'] 	= splitname($user->name, 18);
			$result['content']	= str_ireplace(array_keys($smileys), array_values($smileys), $message->value);
		} elseif($message->name == ELGGCHAT_SYSTEM_MESSAGE) {
			$result['offset'] = $offset;
			$result['content'] = $message->value;
			$result['guid'] = '0';
		}
		echo json_encode($result);
	}
?>