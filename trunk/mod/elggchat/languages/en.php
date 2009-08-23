<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* English language file
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	$english = array(
		'elggchat' => "Chat",
		'elggchat:title' => "Chat",
		'elggchat:chat:profile:invite' => "Invite for chat",
		'elggchat:chat:send' => "Send",
		
		'elggchat:friendspicker:info' => "Chat: Friends Online",
		
		'elggchat:conference' => "[Conference]",
		'elggchat:chat:invite' => "Invite",
		'elggchat:chat:minimize' => "Minimize",
		'elggchat:chat:leave' => "Leave",
		'elggchat:chat:leave:confirm' => "Are you sure you wish to leave this session?",
		'elggchat:chat:info' => "Info",
		
		'elggchat:action:invite' => "<b>%s</b> invited <b>%s</b>",
		'elggchat:action:invite_friends' => "Invite Friends",
		'elggchat:action:leave' => "<b>%s</b> left the session",
		'elggchat:action:join' => "<b>%s</b> joined the session",
		
		'elggchat:session_info:title' => "Session Information",
		'elggchat:session_info:id' => "id:",
		'elggchat:session_info:started' => "started:",
		'elggchat:session_info:members' => "Members",
		'elggchat:session_info:invitations' => "Outstanding Invitations",

		'elggchat:session:name:default' => "[Session %s]",
		'elggchat:session:onlinestatus' => "Last action: %s",
		
		// Plugin settings
		'elggchat:admin:settings:hours' => "%s hour(s)",
	
		'elggchat:admin:settings:maxsessionage' => "Max time a session can remain idle before cleanup",
		
		'elggchat:admin:settings:chatupdateinterval' => "Polling interval (seconds) of the chat window",
		'elggchat:admin:settings:maxchatupdateinterval' => "Every 10 times of polling with no data returned the polling interval will be multiplied until it reaches this maximum (seconds)",
		'elggchat:admin:settings:monitorupdateinterval' => "Polling interval (seconds) of the chat session monitor, which checks for new chat requests",

		'elggchat:admin:settings:online_status:active' => "Max number of seconds before user will be idle",
		'elggchat:admin:settings:online_status:inactive' => "Max number of seconds before user will be inactive",
		
		// User settings
		'elggchat:usersettings:enable_chat' => "Enable Chat Toolbar?",
	
		// Toolbar actions
		'elggchat:toolbar:minimize' => "Minimize Chat Toolbar",
		'elggchat:toolbar:maximize' => "Maximize Chat Toolbar",
	);
					
	add_translation("en", $english);

?>