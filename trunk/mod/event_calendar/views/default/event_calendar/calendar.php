<?php
if ($vars['mode']) {
	$mode = $vars['mode'];
} else {
	$mode = 'month';
}
$link_bit = $vars['url'].'mod/event_calendar/show_events.php?start_date='.$vars['original_start_date'].'&group_guid='.$vars['group_guid'].'&filter='.$vars['filter'].'&mode=';

$body .= elgg_view("input/datepicker_inline",
		array(
			'internalname' 	=> 'my_datepicker',
			'mode' 			=> $vars['mode']?$vars['mode']:'month',
			'start_date' 	=> $vars['start_date'],
			'end_date' 		=> $vars['end_date'],
			'group_guid'	=> $vars['group_guid']
		)
);
$body .= '<div id="calendarmenucontainer">';
$body .= '<ul id="calendarmenu">';
if ($mode == 'day') {
	$link_class = ' class="sys_selected"';
} else {
	$link_class = '';
}
$body .= '<li'.$link_class.'><a href="'.$link_bit.'day">'.elgg_echo('event_calendar:day_label').'</a></li>';
if ($mode == 'week') {
	$link_class = ' class="sys_selected"';
} else {
	$link_class = '';
}
$body .= '<li'.$link_class.'><a href="'.$link_bit.'week">'.elgg_echo('event_calendar:week_label').'</a></li>';
if ($mode == 'month') {
	$link_class = ' class="sys_selected sys_calmenu_last"';
} else {
	$link_class = ' class="sys_calmenu_last"';
}
$body .= '<li'.$link_class.'><a href="'.$link_bit.'month">'.elgg_echo('event_calendar:month_label').'</a></li>';
$body .= '</ul>';
$body .= '</div>';
echo $body;
?>