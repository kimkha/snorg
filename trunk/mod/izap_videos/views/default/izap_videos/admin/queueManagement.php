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
// some actions
$option = get_input('option', false);
if($option == 'reset'){
  set_plugin_setting('isQueueRunning', 'no', 'izap_videos');
  forward($_SERVER['HTTP_REFERER']);
}elseif($option == 'delete'){
  $queue = get_entities('object', 'izapVideoQueue', 0, 'time_created', 0);
  foreach ($queue as $que) {
    izapDeleteVideo_izap_videos($que->videoId);
    izapDeleteQueueObject_izap_videos($que);
  }
  set_plugin_setting('isQueueRunning', 'no', 'izap_videos');
  forward($_SERVER['HTTP_REFERER']);
}

?>
<div id="videoQueue" align="center">
  <img src="<?php echo $vars['url'] . 'mod/izap_videos/graphics/video_converting.gif'?>" />
</div>

<script type="text/javascript">
  function checkQueue(){
      $('#videoQueue').load('<?php echo $vars['url'] . 'mod/izap_videos/getQueue.php'?>');
    }
  $(document).ready(function(){
    checkQueue();
    setInterval(checkQueue, 5000);
  });
</script>