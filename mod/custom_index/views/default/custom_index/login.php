<?php

	/**
	 * Rewrite to make it more intelligent
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	if (isloggedin()){
		$login_user = get_loggedin_user();
		$login = "<div id='welcome-box'>";
		$login .= "<h2>" . elgg_echo("welcome") . " ";
		$login .= "<a href='". $vars['url'] ."pg/profile/". $login_user->username. "'>".$login_user->name."</a>";
		$login .= "</h2>";
		$login .= "</div>";
	}
	else {
		$login = elgg_view("account/forms/login");
	}
	
	echo $login;
?>