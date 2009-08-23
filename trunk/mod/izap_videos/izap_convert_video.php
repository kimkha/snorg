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

// only works if started from command line
if($argc > 1 && $argv[1] == 'izap' && $argv[2] == 'web'){
  set_plugin_setting('isQueueRunning', 'yes', 'izap_videos');
  echo 'Queue started.........................RUNNING..............';
  izapRunQueue_izap_videos();
  set_plugin_setting('isQueueRunning', 'no', 'izap_videos');
  echo '______________ :) Done__________';
}

function izapRunQueue_izap_videos() {
  $queue = get_entities('object', 'izapVideoQueue', 0, 'time_created', 0);
  if(is_array($queue)){
    foreach($queue as $pending) {
      $converted = izapConvertVideo_izap_videos($pending->mainFile, $pending->videoId, $pending->videoTitle, $pending->videoUrl, $pending->videoOwner);

      // if the video is not converted properly then delete it
      if(!$converted){
        if(!izapDeleteVideo_izap_videos($pending->videoId))
          echo 'Video Entity not deleted';
      }
      
      // finally delete the entry from queue
      izapDeleteQueueObject_izap_videos($pending);
    }

    // recheck if there is new video in the queue
    $queue = get_entities('object', 'izapVideoQueue', 0, 'time_created');
    if(is_array($queue))
      izapRunQueue_izap_videos();
  }

  return ;
}
forward('http://www.izap.in');
?>