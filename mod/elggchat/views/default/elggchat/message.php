<?php
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
		$result = "";
		if($message->name == ELGGCHAT_MESSAGE){
			$cont_mes = json_decode($message->value);
			$result .= "<div name='message' id='" .  $offset . "' class='messageWrapper'>";
			
			$result .= "<table ><tr><td class='messageName'>" . splitname($user->name, 18) . "</td><td class='messageTime'>";
			$result .= date("h:i A", $cont_mes->time-(60*60));
			$result .= "</td></tr>";
			
			$result .= "<tr><td colspan='2' class='messageContent'>";

			$result .= str_ireplace(array_keys($smileys), array_values($smileys), $cont_mes->message);
			$result .= "</td></tr></table>";
			$result .= "</div>";
		} elseif($message->name == ELGGCHAT_SYSTEM_MESSAGE) {
			$result .= "<div name='message' id='" .  $offset . "' class='systemMessageWrapper'>";
			$result .= $message->value;
			$result .= "</div>";
		}
		echo $result;
	}
?>