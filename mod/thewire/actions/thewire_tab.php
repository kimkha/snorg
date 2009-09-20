<?php

	set_page_owner(get_input('owner'));
	$page_owner = page_owner_entity();
	$thewire = $page_owner->getObjects('thewire', 5);
	
	echo "<div id='thewire-tab'>";
	if ($thewire != '') {
		echo elgg_view("thewire/view", array('entity' => $thewire));
	}
	else {
		echo '<i>'.elgg_echo("thewire:nomessage").'</i>';
	}
	echo "</div>";
	exit();
?>