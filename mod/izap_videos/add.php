<?php
/**
* iZAP izap_videos
*
* @package youtube, vimeo, veoh and onserver uploading
* @license GNU Public License version 3
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.5-2.0
*/

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
gatekeeper();
$page_owner = page_owner_entity();

$area2 = elgg_view_title(elgg_echo('izap_videos:add'));
$area2 .= elgg_view('izap_videos/form');

// get tags and categories
$area3 = elgg_view('izap_videos/area3');
$body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);

page_draw(sprintf(elgg_echo('izap_videos:user'),$page_owner->name),$body);