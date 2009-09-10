<?php

gatekeeper();

//get unread messages
$num_fr = count_events_requests();
//echo "<pre>"; print_r($num_fr); die;
if($num_fr){
	$num = $num_fr;
} else {
	$num = 0;
}

if($num > 0){ ?>
	<a href="<?php echo $vars['url']; ?>pg/eventrequests" class="new_eventrequests" title="<?php echo elgg_echo('newfriendrequests'); ?>">[<?php echo $num; ?>]</a>
<?php } ?>