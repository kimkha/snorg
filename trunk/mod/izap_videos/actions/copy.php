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

$videoId = get_input('videoId');
$video = izapVideoCheck_izap_videos($videoId);

$newVideo = new ElggObject();
$newVideo->subtype = "izap_videos";
$newVideo->container_guid = get_loggedin_userid();
$newVideo->access_id = ACCESS_PUBLIC;
$newVideo->tags = $video->tags;
$newVideo->title = $video->title;
$newVideo->description = $video->description;
$newVideo->videotype = $video->videotype;
$newVideo->autoplay = $video->autoplay;
$newVideo->views = 1;
$newVideo->copiedFrom = $video->owner_guid;
$newVideo->copiedVideoId = $_SERVER['HTTP_REFERER'];
$newVideo->copiedVideoUrl = $videoId;
$newVideo->imagesrc = $video->imagesrc;
izapCopyFiles_izap_videos($video->owner_guid, $video->imagesrc);

if($video->videotype == 'uploaded'){
  $newVideo->converted = $video->converted;
  $newVideo->videofile = $video->videofile;
  izapCopyFiles_izap_videos($video->owner_guid, $video->videofile);
  $newVideo->orignalfile = $video->orignalfile;
  izapCopyFiles_izap_videos($video->owner_guid, $video->orignalfile);
}else{
  $newVideo->videosrc = $video->videosrc;
}

if($newVideo->save()){
  system_message(elgg_echo('izap_videos:success:videoCopied'));
  forward($newVideo->getURL());
}else{
  system_message(elgg_echo('izap_videos:success:videoNotCopied'));
  forward($_SERVER['HTTP_REFERER']);
}
