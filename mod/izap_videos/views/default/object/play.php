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

if (isset($vars['entity']) and $vars['entity']->getSubtype() == 'izap_videos')
{
  // checks the video src is it onserver or off server
	$video_src = $vars['entity']->videosrc;
	if(!$video_src)
		$video_src = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?id=" . $vars['entity']->getGUID();

  // gets back the player code
  if(izapVideoNotConverted_izap_videos($vars['entity'])){
    $playerClass = 'class="notConvertedWrapper"';
    $player = '<h3>'.elgg_echo('izap_videos:processed').'</h3>';
  }else{
    $player = izapGetPlayer_izap_videos($vars['entity']->videotype, $video_src, $vars['entity']->autoplay);
    $playerClass = 'class="contentWrapper"';

    // this will update the views
    izapUpdateViews_izap_videos($vars['entity']->guid, $vars['entity']->views);
  }

if ($vars['entity']->canEdit())
{
		$DeleteEdit .= '' . elgg_view("output/confirmlink", array(
													'href' => $vars['url'] . "action/izap_videos/delete?video_id=" . $vars['entity']->getGUID(),
													'text' => elgg_echo('delete'),
													'confirm' => elgg_echo('izap_videos:remove'),
												));
		$DeleteEdit .= '&nbsp;&nbsp;';
		$DeleteEdit .= '<a href="' . $vars['url']  . 'pg/izap_videos/' . $vars['entity']->getOwnerEntity()->username . '/edit/' . $vars['entity']->getGUID() . '">' . elgg_echo('izap_videos:edit') . '</a>';
    $DeleteEdit .= '&nbsp;&nbsp;';
}

// copy video link only shows up if the user is loggedin,
// video doesn't belongs to loggedin user and
// video is converted(in case of uploaded videos)
  if(($vars['entity']->owner_guid != get_loggedin_userid()) && isloggedin() && !izapVideoNotConverted_izap_videos($vars['entity']))
    $Add = '<div class="contentWrapper"><h3 align="center"><a href="' . $CONFIG->wwwroot . 'action/izap_videos/copy?videoId=' . $vars['entity']->getGUID() . '">' . elgg_echo('izap_videos:addtoyour') . '</a></h3></div>';
?>
	<div>
			<?php
				echo elgg_view_title(elgg_echo($vars['entity']->title));
				echo $Add;
			?>
	<div align="center" <?php echo $playerClass;?>>
		<?php echo $player; ?>
	</div>
    
	<div class="contentWrapper">
		<div class="generic_comment">
		<div class="generic_comment_icon">
		    <?php
		        echo elgg_view("profile/icon",array('entity' => $vars['entity']->getOwnerEntity(), 'size' => 'small'));
			?>
			<div style="background:#DEDEDE;color:#0054A7;text-align:center"><h3><?php echo ((!$vars['entity']->views) ? '0' : $vars['entity']->views)?></h3></div>
		</div>
		<div class="generic_comment_details">
		<p>
				<?php
	                
					echo sprintf(elgg_echo("izap_videos:time"),
									date("F j, Y",$vars['entity']->time_created)
					);
				
				?>
				<?php echo elgg_echo('by'); ?> <a href="<?php echo $vars['url']; ?>pg/izap_videos/<?php echo $vars['entity']->getOwnerEntity()->username; ?>"><?php echo $vars['entity']->getOwnerEntity()->name; ?></a> &nbsp; 
				<!-- display the comments link -->
        <?php
            echo $DeleteEdit . sprintf(elgg_echo("comments")) . " (" . elgg_count_comments($vars['entity']) . ")";
            // if the video is copied
            if((int)$vars['entity']->copiedFrom > 0){
              $owner = get_user($vars['entity']->copiedFrom);
              echo ' <span class="copied_text">[' . elgg_echo('izap_videos:copiedFrom') . ': <a href="' . $vars['entity']->copiedVideoUrl . '">' . $owner->name . '</a>]</span>';
            }
            
            $tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
            if(!empty($tags))
              echo '<p class="generic_comment_owner">' . elgg_echo('izap_videos:tags') . ': ' . $tags . '</p>';
				?>
			</p> 
			 </div>
			</div>
			<div>
			 	<?php
				  echo $vars['entity']->description;
			 	?>
			 </div>
	</div>
    <div ><?php echo elgg_view_title(elgg_echo('izap_videos:embedCode'));?>
    <div id="videoSrc" class="contentWrapper">
        <?echo elgg_view('input/text', array('value' => str_replace('"', '\'', $player), 'js' => 'onClick = this.select() READONLY'))?>
    </div>
    </div>
    <?php
      echo elgg_view('izap_videos/customindexVideos', array('videosTOdisplay' => 28));
      // view for other plugins to extend
      echo elgg_view('izap_videos/extendedPlay');
    ?>
</div>
<?php
// echo comments
echo elgg_view_comments($vars['entity']);
}