<?php
$options = array(elgg_echo('event_calendar:settings:yes')=>'yes',
	elgg_echo('event_calendar:settings:no')=>'no',
);

$event_calendar_autopersonal = get_plugin_setting('autopersonal', 'event_calendar');
if (!$event_calendar_autopersonal) {
	$event_calendar_autopersonal = 'yes';
}

$body = '';

$body .= elgg_echo('event_calendar:settings:autopersonal:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[autopersonal]','value'=>$event_calendar_autopersonal,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:no')=>'no',
	elgg_echo('event_calendar:settings:site_calendar:admin')=>'admin',
	elgg_echo('event_calendar:settings:site_calendar:loggedin')=>'loggedin',
);

$event_calendar_site_calendar = get_plugin_setting('site_calendar', 'event_calendar');
if (!$event_calendar_site_calendar) {
	$event_calendar_site_calendar = 'admin';
}

$body .= elgg_echo('event_calendar:settings:site_calendar:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[site_calendar]','value'=>$event_calendar_site_calendar,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:no')=>'no',
	elgg_echo('event_calendar:settings:group_calendar:admin')=>'admin',
	elgg_echo('event_calendar:settings:group_calendar:members')=>'members',
);

$event_calendar_group_calendar = get_plugin_setting('group_calendar', 'event_calendar');
if (!$event_calendar_group_calendar) {
	$event_calendar_group_calendar = 'members';
}

$body .= elgg_echo('event_calendar:settings:group_calendar:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_calendar]','value'=>$event_calendar_group_calendar,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:group_default:yes')=>'yes',
	elgg_echo('event_calendar:settings:group_default:no')=>'no',
);

$event_calendar_group_default = get_plugin_setting('group_default', 'event_calendar');
if (!$event_calendar_group_default) {
	$event_calendar_group_default = 'yes';
}

$body .= elgg_echo('event_calendar:settings:group_default:title');
$body .= '<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_default]','value'=>$event_calendar_group_default,'options'=>$options));

$body .= '<br />';

$options = array(elgg_echo('event_calendar:settings:group_profile_display_option:left')=>'left',
	elgg_echo('event_calendar:settings:group_profile_display_option:right')=>'right',
	elgg_echo('event_calendar:settings:group_profile_display_option:none')=>'none',
);

$event_calendar_group_profile_display = get_plugin_setting('group_profile_display', 'event_calendar');
if (!$event_calendar_group_profile_display) {
	$event_calendar_group_profile_display = 'right';
}

$body .= elgg_echo('event_calendar:settings:group_profile_display:title').'<br />';
$body .= elgg_view('input/radio',array('internalname'=>'params[group_profile_display]','value'=>$event_calendar_group_profile_display,'options'=>$options));

echo $body;
?>