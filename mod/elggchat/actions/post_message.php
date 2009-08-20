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
	$timestamp = date('H:i:s', strtotime("-1 hours"));
	if(check_entity_relationship($sessionId, ELGGCHAT_MEMBER, $userId)){
		$input = get_input("chatmessage");
		$input = wordwrap($input, 25, "<wbr />", true);
		
		$chat_message = nl2br($input)."<P style='color:grey;font-size:10px;'> posted at ".$timestamp."</P>";
		
		if(!empty($chat_message)){
			$session = get_entity($sessionId);
			
			$session->annotate(ELGGCHAT_MESSAGE, $chat_message, ACCESS_LOGGED_IN, $userId);
			$session->save();
		}
	}
	exit(); 
?>