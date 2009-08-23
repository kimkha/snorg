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

  $pageOwner = page_owner_entity();
  // get categories
  $categories = elgg_view('categories/list', array('baseurl' => $CONFIG->wwwroot . 'search/?subtype=izap_videos&tagtype=universal_categories&tag=', 'owner_guid' => $pageOwner->guid));
  if(!empty($categories))
    $area3 .= '<div class="contentWrapper">' . $categories . '</div>';
    
  // get tags
  $tags = display_tagcloud(0,50,'tags','object','izap_videos','','');
  if($tags != ''){
    $area3 .= '<div class="contentWrapper">';
    $area2 .= elgg_view_title(elgg_echo('izap_videos:tagcloud'));
    $area3 .= $tags;
    $area3 .= '</div>';
  }
  echo $area3;
  