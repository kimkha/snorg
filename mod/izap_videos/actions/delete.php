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
$guid = (int) get_input('video_id');
$izap_videos = get_entity($guid);

// if video is not converted yet then delete its entry from the queue
if($izap_videos->converted == 'no'){
  $queueEntry = get_entities_from_metadata('videoId', $guid, 'object', 'izapVideoQueue', $izap_videos->owner_guid);
  izapDeleteQueueObject_izap_videos($queueEntry[0]);
}

  $owner = get_entity($izap_videos->container_guid);
  $owner_guid = $owner->getGUID();
  $imagesrc = $izap_videos->imagesrc;
  $filesrc = $izap_videos->videofile;
  $ofilesrc = $izap_videos->orignalfile;

   if ($izap_videos->delete()) {
     // if video deleted and video was converted then delete the files as well
      if($izap_videos->converted == 'yes'){
        $fileread = new ElggFile();
        $fileread->owner_guid = $izap_videos->owner_guid;

        $fileread->setFilename($imagesrc);
        $image_file = $fileread->getFilenameOnFilestore();
        @unlink($image_file);

        $fileread->setFilename($filesrc);
        $video_file = $fileread->getFilenameOnFilestore();
        @unlink($video_file);
        
        $fileread->setFilename($ofilesrc);
        $orignal_file = $fileread->getFilenameOnFilestore();
        @unlink($orignal_file);

        $fileread->close();
      }
  	system_message(elgg_echo("izap_videos:deleted"));
  } else {
  	register_error(elgg_echo("izap_videos:notdeleted"));
  }
    forward("pg/izap_videos/" . $owner->username);