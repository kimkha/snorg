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
	
	$id = (int) get_input('id');
	$entity = get_entity($id);
	$user = $entity->getOwnerEntity();
	
	if ($entity->delete()) {
		system_message(elgg_echo("stick:user:removesuccessful"));
		forward("pg/profile/".$user->username);
	} else {
		register_error(elgg_echo("stick:user:removeerror"));
		forward($_SERVER['HTTP_REFERER']);
	}
	
?>