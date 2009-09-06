<?php

	/**
	 * Demo content for tabs of profile
	 * 
	 * @author KimKha
	 * 
	 */
	
	$user = get_user(get_input("owner", 0));
	if ($user)
		echo elgg_view("profile/details", array('entity' => $user, 'full' => true));
	
?>