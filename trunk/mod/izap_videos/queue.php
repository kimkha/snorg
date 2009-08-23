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

// only for admins
admin_gatekeeper();
// set to admin
set_context('admin');

// get page contents
$area2 = elgg_view_title(elgg_echo('izap_videos:queueManagement'));
$area2 .= elgg_view('izap_videos/admin/queueManagement');


// finally draw page
page_draw(elgg_echo('izap_videos:queueManagement'), elgg_view_layout("two_column_left_sidebar", '', $area2));

