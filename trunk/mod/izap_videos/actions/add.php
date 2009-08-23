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

$owner = get_input("izapPageOwner");
$page_owner = get_entity($owner);
$accessid = get_input("izapVideoAccess");
$title = get_input("izapVideoTitle");
$description = get_input("izapVideoDescription");
$tags = get_input("izapVideoTags");
//$autoplay = get_input("izap_videoautoplay");
$url = get_input("izapVideoUrl");
$embedCode = get_input('izapVideoEmbed', '', FALSE);
$inputVideoType = get_input('izapVideoType');

$_SESSION['postedData'] = array(
    'page_owner' => $owner,
    'izap_videosaccessid' => $accessid,
    'izap_videostitle' => $title,
    'izap_videosdescription' => $description,
    'izap_videostags' => $tags,
    'izap_videosurl' => $url,
    'izap_embed_code' => $embedCode,
    'inputTab' => $inputVideoType,
);


$izap_videos = new ElggObject();
$izap_videos->subtype = "izap_videos";
$izap_videos->container_guid = $owner;
$izap_videos->access_id = $accessid;
$izap_videos->tags = string_to_tag_array($tags);


// FILE
if($inputVideoType == 'IZAP_FILE')
{ 
  // check for the 0 size files
  if(isset($_FILES['izapVideoFile'])){
    if((int)$_FILES['izapVideoFile']['size'] == 0){
      register_error(elgg_echo('izap_videos:error:zeroFile'));
      forward($_SERVER['HTTP_REFERER']);
    }
  }

  // check title first
  if(empty($title))
	{
		register_error(elgg_echo('izap_videos:blanktitle'));
		forward("pg/izap_videos/" . $page_owner->username . "/add");
		exit;
	}

  // if the paths are not specified then move back
  if(!izapCheckPluginSettings_izap_videos()){
    register_error(elgg_echo('izap_videos:error:uploadNotSupported'));
    forward($_SERVER['HTTP_REFERER']);
  }
	
	// check supported video type
  if(!izapSupportedVideos_izap_videos($_FILES['izapVideoFile']['name'])){
    register_error(elgg_echo('izap_videos:unsupported'));
    forward($_SERVER['HTTP_REFERER']);
    exit;
  }
  
  // check supported video size
  if(!izapCheckFileSize_izap_videos($_FILES['izapVideoFile']['size'])){
    register_error(elgg_echo('izap_videos:error:maxFile'));
    forward($_SERVER['HTTP_REFERER']);
    exit;
  }
  
  $newFileName = str_replace(' ', '_', $_FILES['izapVideoFile']['name']);
  
  $filehandler = new ElggFile();
	$filehandler->setFilename('tmp/' . $newFileName);
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('izapVideoFile'));
  
  $tmpFile = $filehandler->getFilenameOnFilestore();
  $tmpImage = izapTakePhoto_izap_videos($tmpFile);

	$izap_videos->title = $title;
  $izap_videos->description = $description;
  $izap_videos->videotype = 'uploaded';
  //$izap_videos->autoplay = $autoplay;
  $izap_videos->views = 1;
  if($tmpImage)
    $izap_videos->imagesrc = $tmpImage;
  else
    $izap_videos->imagesrc = $CONFIG->wwwroot . 'mod/izap_videos/graphics/video_converting.gif';
  $izap_videos->converted = 'no';
  $izap_videos->videofile = 'nop';
  $izap_videos->orignalfile = 'nop';
}
// URL
elseif($inputVideoType == 'IZAP_URL')
{
$izap_videos->videourl = $url;

$image_path = $CONFIG->pluginspath . 'izap_videos/images/';
$izap_vid = new izapVideo($url);

	if(!isset($izap_vid->type))
	{
		register_error(elgg_echo('izap_videos:blank'));
		forward("pg/izap_videos/" . $page_owner->username . "/add");
	}

  // capture the video
	$values = $izap_vid->capture();
	if(!is_object($values))
	{
		register_error(elgg_echo('izap_videos:errorCode'.$values));
		forward("pg/izap_videos/" . $page_owner->username . "/add");
	}

$izap_videos->title = ($title != '') ? $title : $values->title;
$izap_videos->description = ($description != '') ? $description : $values->description;
$izap_videos->videosrc = $values->videoSrc;
$izap_videos->videotype = $values->type;
//$izap_videos->autoplay = $autoplay;
$izap_videos->views = 1;
$izap_videos->imagesrc = "izap_videos/" . $values->type . "/" . $values->fileName;

// add more tags if avialable
$izap_videos->tags = string_to_tag_array(str_replace('"','',trim($values->videoTags)));

$filehandler = new ElggFile();
$filehandler->setFilename($izap_videos->imagesrc);
$filehandler->open("write");
$filehandler->write($values->fileContent);

$thumb = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),120,90, true);

$filehandler->setFilename($izap_videos->imagesrc);
$filehandler->open("write");
$filehandler->write($thumb);
$filehandler->close();
}
// EMBED
elseif($inputVideoType == 'IZAP_EMBED'){

  // check title first
  if(empty($embedCode))
	{
		register_error(elgg_echo('izap_videos:error:embedCode'));
		forward("pg/izap_videos/" . $page_owner->username . "/add");
		exit;
	}
  
  // check title first
  if(empty($title))
	{
		register_error(elgg_echo('izap_videos:blanktitle'));
		forward("pg/izap_videos/" . $page_owner->username . "/add");
		exit;
  }

  $izap_videos->videotype = 'embed';
  $izap_videos->videosrc = $embedCode;
  $izap_videos->title = $title;
  $izap_videos->description = $description;
  $izap_videos->views = 1;
  $izap_videos->imagesrc = "izap_videos/embed/" . time() . '.jpg';

  $filehandler = new ElggFile();
  $filehandler->setFilename($izap_videos->imagesrc);
  $filehandler->open("write");
  $filehandler->write(get_uploaded_file('izapVideoEmbedImage'));

  $thumb = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),120,90, true);

  $filehandler->setFilename($izap_videos->imagesrc);
  $filehandler->open("write");
  $filehandler->write($thumb);
  $filehandler->close();
  
}else{
  register_error(elgg_echo('izap_videos:error:invalidInput'));
  forward($_SERVER['HTTP_REFERER']);
  exit;
}

if(empty($izap_videos->description))
  $izap_videos->description = elgg_echo('izap_videos:noDescription');


  if(!$izap_videos->save()){
		register_error(elgg_echo('izap_videos:saveerror'));
		forward("pg/izap_videos/" . $page_owner->username);
		exit;
	}
  
// save the file info for converting it later  in queue
izapSaveFileInfoForConverting_izap_videos($tmpFile, $izap_videos, $accessid);

add_to_river('river/object/izap_videos/create', 'create', $page_owner->guid, $izap_videos->guid);
system_message(elgg_echo('izap_videos:saved'));
unset($_SESSION['postedData']);
forward($izap_videos->getUrl());