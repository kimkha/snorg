<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Extend the menu on a User's profile icon, with the option to create a chat session
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/
	
	if(!($vars['entity']->getGUID() == get_loggedin_userid())){
		echo "<p class=\"user_menu_removefriend\"><a href=\"javascript:startSession(" . $vars['entity']->getGUID() . ");\">" . elgg_echo("elggchat:chat:profile:invite") . "</a></p>";
	}
?>