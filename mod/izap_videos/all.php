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

$page_owner = page_owner_entity();

if ($page_owner === false || is_null($page_owner)) {
  $page_owner = $_SESSION['user'];
  set_page_owner($_SESSION['guid']);
}

// get page contents
$area2 = elgg_view_title(elgg_echo('izap_videos:all'));
$area2 .= list_entities('object','izap_videos',0,10,false);

// get tags and categories
$area3 = elgg_view('izap_videos/area3');

// finally draw page
page_draw(sprintf(elgg_echo('izap_videos:all'),$page_owner->name), elgg_view_layout("two_column_left_sidebar", '', $area2, $area3));