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

gatekeeper();
action_gatekeeper();

$videoId = (int) get_input('izapVideoId');
$accessid = get_input("izapVideoAccess");
$title = get_input("izapVideoTitle");
$description = get_input("izapVideoDescription");
$tags = get_input("izapVideoTags");
$embedCode = get_input('izapVideoEmbed', FALSE);
//$autoplay = get_input("izap_videoautoplay");

if(empty($title))
{
	register_error(elgg_echo('izap_videos:blank:title'));
	forward($_SERVER['HTTP_REFERER']);
}
// check the video for security reasons
$izap_videos = izapVideoCheck_izap_videos($videoId, TRUE);

// start saving entity
$izap_videos->title = $title;
$izap_videos->access_id = $accessid;
$izap_videos->description = $description;
$izap_videos->tags = string_to_tag_array($tags);
//$izap_videos->autoplay = $autoplay;

if($izap_videos->videotype == 'embed' && $embedCode){
  $izap_videos->videosrc = $embedCode;
  $imageContent = get_uploaded_file('izapVideoEmbedImage');
  if($imageContent != ''){
    $izap_videos->imagesrc = "izap_videos/embed/" . time() . '.jpg';
    // SAVE IMAGE FOR EMBED VIDEO
    $filehandler = new ElggFile();
    $filehandler->setFilename($izap_videos->imagesrc);
    $filehandler->open("write");
    $filehandler->write($imageContent);

    $thumb = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),120,90, true);

    $filehandler->setFilename($izap_videos->imagesrc);
    $filehandler->open("write");
    $filehandler->write($thumb);
    $filehandler->close();
  }
}

if(!$izap_videos->save())
{
  register_error(elgg_echo('izap_videos:saveerror'));
  forward($_SERVER['HTTP_REFERER']);
}
else
{
  system_message(elgg_echo('izap_videos:saved'));
  forward($izap_videos->getUrl());
}