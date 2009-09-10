<?php
$allselect = ''; $friendsselect = ''; $mineselect = '';
switch($vars['filter']) {
	case 'all':		$allselect = 'class="selected"';
					break;
	case 'friends':		$friendsselect = 'class="selected"';
					break;
	case 'mine':		$mineselect = 'class="selected"';
					break;
}

$url_start = $vars['url'].'mod/event_calendar/show_events.php?group_guid='.$vars['group_guid'].'&amp;mode='.$vars['mod'];

?>
<div id="elgg_horizontal_tabbed_nav">
	<ul>
		<li <?php echo $allselect; ?> ><a onclick="javascript:$('#event_list').load('<?php echo $url_start; ?>&amp;filter=all&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;filter=all&amp;callback=true"><?php echo elgg_echo('all'); ?></a></li>
		<li <?php echo $friendsselect; ?> ><a onclick="javascript:$('#event_list').load('<?php echo $url_start; ?>&amp;filter=friends&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;filter=friends&amp;callback=true"><?php echo elgg_echo('friends'); ?></a></li>
		<li <?php echo $mineselect; ?> ><a onclick="javascript:$('#event_list').load('<?php echo $url_start; ?>&amp;filter=mine&amp;callback=true'); return false;" href="<?php echo $url_start; ?>&amp;filter=mine&amp;callback=true"><?php echo elgg_echo('mine'); ?></a></li>
	</ul>
</div>