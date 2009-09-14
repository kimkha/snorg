
<?php

$viewer = get_loggedin_user();
	if($viewer) {
		$friends = get_entities_from_relationship('friend', $viewer->getGUID(), false, 'user', '', 0, 'time_created desc', 1000);
		
		if ($friends) {
			foreach($friends as $friend) {
				$friend_array[$friend->name] = $friend->getGUID();
			}
		}
		ksort($friend_array);

		$content = "<input type='hidden' name='image_guid' value='{$file_guid}' />";
		$content .= "<input type='hidden' name='coordinates' id='coordinates' value='' />";
		$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
		$content .= "<input type='hidden' name='word' id='word' value='' />";
	
		$content .= "<ul id='tidypics_phototag_list'>";
		$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($friends) {
			foreach($friend_array as $friend_name => $friend_guid) {
				$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$friend_guid}, \"{$friend_name}\")'>{$friend_name}</a></li>";
			}
		}
	}
	$content .= "</ul>";

	$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiontag') . "' class='submit_button' />";
	
	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'tidypics_phototag_form', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/tidypics/addtag", 'body' => $content));

?>
