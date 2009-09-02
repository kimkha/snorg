<?php

	/**
	 * Demo content for tabs of profile
	 * 
	 * @author KimKha
	 * 
	 */
	
	$user = get_loggedin_user();
	echo elgg_view("profile/details", array('entity' => $user, 'full' => true));
?>