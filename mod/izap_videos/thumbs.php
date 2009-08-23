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

$guid = get_input("id");

if(!$guid)
$guid = current(explode('.', get_input("file")));

$what = get_input("what");
$izap_videos = get_entity($guid);

if($izap_videos){
  if($what == 'image')
    $filename = $izap_videos->imagesrc;
  elseif(!isset($what) or empty($what))
    $filename = $izap_videos->videofile;

  $fileread = new ElggFile();
  $fileread->owner_guid = $izap_videos->owner_guid;
  $fileread->setFilename($filename);
  $fileread->open("read");
  $contents = $fileread->grabFile();
  $fileread->close();

  if($contents == ''){
    $contents = file_get_contents($CONFIG->pluginspath . 'izap_videos/graphics/noimage.png');
  }
  
  if($what == 'image')
    header("Content-type: image/jpeg");
  elseif(!isset($what) or empty($what))
    header("Content-type: application/x-flv");

  header("Content-Disposition: inline; filename=\"$filename\"");

  echo $contents;
  }
?>