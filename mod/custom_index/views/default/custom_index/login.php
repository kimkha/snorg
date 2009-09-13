<?php

	/**
	 * Elgg custom index
	 * 
	 * @author KimKha
	 * @package ElggCustomIndex
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
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