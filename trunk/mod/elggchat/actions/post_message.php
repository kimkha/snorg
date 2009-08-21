<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Action to post a message in a chat session
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	gatekeeper();
	
	$sessionId = (int) get_input("chatsession");
	$userId = get_loggedin_userid();
	$timestamp = time();
//	$timestamp = date('H:i A', strtotime("-1 hours"));
	if(check_entity_relationship($sessionId, ELGGCHAT_MEMBER, $userId)){
		$input = get_input("chatmessage");
		$input = wordwrap($input, 10, "<wbr>", true);
		
		$chat_message = nl2br($input);
		
		if(!empty($chat_message)){
			$session = get_entity($sessionId);
			$chat_message = json_encode(array('message' => $chat_message, 'time' => $timestamp));
			$session->annotate(ELGGCHAT_MESSAGE, $chat_message, ACCESS_LOGGED_IN, $userId);
			$session->save();
		}
	}
	exit(); 
?>