<?php

	/**
	 * Mutural friends
	 * 
	 * @author KimKha
	 * @package Snorg
	 */

	$page_owner = page_owner_entity();
	$you = $page_owner->guid;
	$me = $_SESSION['user']->getGUID();
	
	$list = get_user_friends($you);
	shuffle($list);
	
	$mutural = array();
	foreach ($list as $friend) 
	{
		if ($friend->isFriendOf($me)) // This is a mutural friend 
		{
			$mutural[] = $friend;
		}			
	}
?>

	<p>
		<? 
		$offset = get_input('offset', 0);
		$count = count($mutural);
		echo elgg_view_entity_list($mutural, $count, $offset, $count);
		
		?>
	</p>