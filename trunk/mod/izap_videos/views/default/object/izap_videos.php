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
if (isset($vars['entity'])) {
		if(substr_count($vars['entity']->imagesrc,"images") == 0)
			$izap_videos_image = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $vars['entity']->getGUID();

  if(izapVideoNotConverted_izap_videos($vars['entity']))
      $notConverted = ' - (' . elgg_echo('izap_videos:processed') . ')';
      
    if (get_context() == "search") {
         echo elgg_view("izap_videos/listing",$vars);
      }else{
        if ($vars['entity']->canEdit())
        {
          $DeleteEdit .= elgg_view("output/confirmlink", array(
                                'href' => $vars['url'] . "action/izap_videos/delete?video_id=" . $vars['entity']->getGUID(),
                                'text' => elgg_echo('delete'),
                                'confirm' => elgg_echo('izap_videos:remove'),
                              ));
          $DeleteEdit .= '&nbsp;&nbsp;';
          $DeleteEdit .= '<a href="' . $vars['url']  . 'pg/izap_videos/' . $vars['entity']->getOwnerEntity()->username . '/edit/' . $vars['entity']->getGUID() . '">' . elgg_echo('izap_videos:edit') . '</a>';
        }
        else
        {
          $DeleteEdit = '<br />';
        }
        ?>
        <div class="contentWrapper">
            <?php
//              if(izapVideoNotConverted_izap_videos($vars['entity']))
//                echo '<h3><a href="#" class="screenshot" rel="' . $izap_videos_image. '">' .elgg_echo($vars['entity']->title). '</a></h3>';
//              else
                echo '<h3><a href="' . $vars['entity']->getUrl() . '" class="screenshot" rel="' . $izap_videos_image. '">' .elgg_echo($vars['entity']->title) . '</a>' . $notConverted . '</h3>';
            ?>

            <div class="generic_comment">
              <div class="generic_comment_icon">
                <a href="<?php echo $vars['entity']->getUrl()?>" class="screenshot" rel="<?php echo $izap_videos_image;?>"><img src="<?php  echo $izap_videos_image?>" height="40" width="40" /></a>
                <div style="background:#DEDEDE;color:#0054A7;text-align:center;"><h3><?php echo ((!$vars['entity']->views) ? '0' : $vars['entity']->views)?></h3></div>
              </div>
              <div class="generic_comment_details">
                <?php echo friendly_time($vars['entity']->time_created); ?>
                <?php echo elgg_echo('by'); ?> <a href="<?php echo $vars['url']; ?>pg/izap_videos/<?php echo $vars['entity']->getOwnerEntity()->username; ?>"><?php echo $vars['entity']->getOwnerEntity()->name; ?></a> &nbsp;
                <!-- display the comments link -->
                  <a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo sprintf(elgg_echo("comments")) . " (" . elgg_count_comments($vars['entity']) . ")"; ?></a>
                <?php echo '<p class="generic_comment_owner">' . $DeleteEdit . '</p>';?>
              </div>
            </div>
          </div>
          <?php
      }
}