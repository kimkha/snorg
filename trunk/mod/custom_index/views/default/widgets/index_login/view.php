<?php

    /**
	 * Elgg Friends
	 * Friend widget options
	 * 
	 * @package ElggFriends
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	
	if (isloggedin()){
		echo "<h2>" . elgg_echo("welcome") . " ";
		echo $vars['user']->name;
		echo "</h2>";
	}
	else {
		echo elgg_view("account/forms/login");
	}
	
?>