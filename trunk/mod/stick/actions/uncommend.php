<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	$userId = (int) get_input('userid');
	$user = get_entity($userId);
	
	$object = get_user_objects($userId, _STICK_COMMEND_SUBTYPE_);
	
	$success = false;
	foreach ($object as $o) {
		if ($o->delete()) {
			$success = true;
		}
	}
	
	if ($success) {
		system_message(elgg_echo("stick:user:removesuccessful"));
		forward("pg/profile/".$user->username);
	} else {
		register_error(elgg_echo("stick:user:removeerror"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
?>