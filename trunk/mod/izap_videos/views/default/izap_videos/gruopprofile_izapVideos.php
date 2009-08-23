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

if($vars['entity']->izap_videos_enable != 'no')
{
  echo '<div id="izap_widget_layout">';
  echo '<a href="' .  $CONFIG->wwwroot . "pg/izap_videos/" . page_owner_entity()->username . '"><h2>' . elgg_echo('izap_videos:groupvideos') . '</h2></a>';
  global $CONFIG;
  $num = 10;
  $shares = get_entities('object', 'izap_videos',page_owner(), "", $num, 0, false);

if($shares){
  foreach($shares as $s){
    $izap_videos_image = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $s->getGUID();
    $owner = $s->getOwnerEntity();
    $friendlytime = friendly_time($s->time_created);
    $icon = '<img src="'.$izap_videos_image.'" height="40" width="40">';

    echo "<div class=\"forum_latest\">";
    echo "<div class=\"izap_shares_widget_icon\"><a href=\"{$s->getUrl()}\" class=\"screenshot\" rel=\"{$izap_videos_image}\">" . $icon . "</a></div><div>";
    ?>
    <p class="izap_shares_title"><a href="<?php echo $s->getUrl();?>" class="screenshot" rel="<?php echo $izap_videos_image; ?>"><?php echo substr($s->title,0,30); ?>..</a></p>
    <p class="izap_shares_timestamp" align="right"><small><!--<a href="<?php $owner->getURL();?>"> by : <?php echo $owner->name; ?></a>--> <?php echo $friendlytime; ?></small></p>
    <?php
    echo "</div><div class='clearfloat'></div>";
    echo "</div>";
  }

$user_inbox = $vars['url'] . "pg/izap_videos/" . page_owner_entity()->username;
echo '<div class="forum_latest" align="right"><a href="'.$user_inbox.'">'.elgg_echo('izap_videos:everyone').'</a></div>';
}
  else
  {
      echo '<div class="forum_latest">' . elgg_echo('izap_videos:notfound') . '</div>';
  }
echo '<div class="clearfloat"></div></div>';
}