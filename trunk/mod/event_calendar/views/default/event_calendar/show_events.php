<?php
/**
 * Elgg show events view
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

if ($vars['events']) {
	$event_list = elgg_view_entity_list($vars['events'], $vars['count'], $vars['offset'], $vars['limit'], true, false);
} else {
	$event_list = '<p>'.elgg_echo('event_calendar:no_events_found').'</p>';
}
if (isloggedin()) {
	$nav = elgg_view('event_calendar/nav',$vars);
} else {
	$nav = '';
}

?>
<table width="100%">
<tr><td>
<div id="event_list">
<?php
echo $nav.'<br />'.$event_list;
?>
</div>
</td>
<td align="right">
<?php
echo elgg_view('event_calendar/calendar',$vars);
?>
</td></tr>
</table>