<?php
	set_page_owner(get_input('owner'));
	$page_owner = page_owner_entity();
	
	echo "<div id='cv-tab'>";
	
		echo elgg_view("cv/view");
	
	echo "</div>";
	
	exit();
?>