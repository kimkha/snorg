<?php
	/**
	 * Comment on wall post
	 * 
	 * @author KimKha
	 */
	
	$entity = get_entity(get_input("id"));
	$content = get_input("content", '');
	if ($entity && $content != '') {
		echo "content ".$content;
	}
	exit();
?>