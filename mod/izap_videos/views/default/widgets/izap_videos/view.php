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

// get the choosen video (video choosed by user to display)
$id = $vars['entity']->selected_video;

// gets the video on click to change on flys
$ary = explode("/",$_GET['page']);
if(count($ary) > 1)
  $id = $ary[2];

$displayVideo = get_entity($id);

// if still there is no video, then chooses the latest video added by user
if(!$displayVideo){
  $video = get_entities('object', 'izap_videos',$vars['entity']->owner_guid, "", 1);
  $displayVideo = $video[0];
}

if($displayVideo)
{
      $owner = $displayVideo->getOwnerEntity();
      $friendlytime = friendly_time($displayVideo->time_created);

      // checks the video src is it onserver or off server
      $video_src = $displayVideo->videosrc;
      if(!$video_src)
        $video_src = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?id=" . $displayVideo->getGUID();

      // gets back the player code
      if(izapVideoNotConverted_izap_videos($displayVideo)){
        $playerClass = 'class="notConvertedWrapper"';
        $player = '<h3>'.elgg_echo('izap_videos:processed').'</h3>';
      }else{
        $player = izapGetPlayer_izap_videos($displayVideo->videotype, $video_src, $displayVideo->autoplay, 240, 220);
        $playerClass = 'class="izap_videos_selected"';

        // this will update the views
        izapUpdateViews_izap_videos($displayVideo->guid, $displayVideo->views);
      }      
      ?>
      <div <?php echo $playerClass?>>
        <?php
          echo '<div align="center">' . $player . '</div>';
        ?>
          <a href="<?php echo $displayVideo->getURL();?>"><b><?php echo $displayVideo->title;?></b></a>
      </div>
<?php
}

// video listing starts here on
$num = ($vars['entity']->num_display) ? $vars['entity']->num_display : 4;

// lets get the user videos
$videos = get_entities('object', 'izap_videos',$vars['entity']->owner_guid, "", $num);

if($videos){
  foreach($videos as $video){
    if($video->getGUID() != $id)
    {
      $thumb = $thumb = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $video->getGUID();
      $owner = $video->getOwnerEntity();
      $friendlytime = friendly_time($video->time_created);
      $icon = '<img src="'.$thumb.'" height="40" width="40">';
      ?>
        <div class="izap_shares_widget_wrapper">
          <div class="izap_shares_widget_icon">
               <a href="javascript: izap_vid('<?php echo $vars['url']; ?>',<?php echo $vars['entity']->getGUID(); ?>,<?php echo $video->getGUID(); ?>)"><?php echo $icon?></a>
          </div>

          <div>
              <p class="izap_shares_title"><a href="javascript: izap_vid('<?php echo $vars['url']; ?>',<?php echo $vars['entity']->getGUID(); ?>,<?php echo $video->getGUID(); ?>)"><?php echo substr($video->title,0,30); ?>..</a></p>
              <p class="izap_shares_timestamp" align="right"><small><?php echo $friendlytime; ?></small></p>
          </div>

          <div class="clearfloat"></div>
        </div>
      <?php
    }
  }

  $userVideos = $vars['url'] . "pg/izap_videos/" . $vars['entity']->getOwnerEntity()->username;
  echo '<div class="contentWrapper" align="right"><a href="'.$userVideos.'">'.elgg_echo('izap_videos:everyone').'</a></div>';
}
else
{
  echo '<div class="contentWrapper">' . elgg_echo('izap_videos:notfound') . '</div>';
}