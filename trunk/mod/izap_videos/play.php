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

// get the video id as input 
$video = (int) get_input('izap_videos_video');
$izap_videos_video = izapVideoCheck_izap_videos($video);

// make the video owner page owner
set_page_owner($izap_videos_video->container_guid);
  
$title = $izap_videos_video->title;

// get page contents
$area2 = elgg_view('object/play',array('entity' => $izap_videos_video));

// get tags and categories
$area3 = elgg_view('izap_videos/area3');
$body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);
page_draw($title, $body);