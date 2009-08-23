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

global $CONFIG;
?>
<h1 class="mediaModalTitle">Embed / Upload Media</h1>
<?php
	echo elgg_view('embed/tabs',array('tab' => 'izap_videos', 'internalname' => $vars['internalname']));
?>
<div id='mediaEmbed'>
   <?php
   echo elgg_view('embed/pagination',array(
                                    'offset' => $vars['offset'],
                                    'baseurl' => $vars['baseUrl'],
                                    'limit' => $vars['limit'],
                                    'count' => $vars['count']
                                ));
    echo elgg_view_title(elgg_echo('videos'));

    echo '<div style="margin:10px;">';
        echo '<form onSubmit="video_search(); return false">';
            echo '<input type="text" id="search" onclick="javascript: if(this.value==\'Search on tags\') this.value=\'\';" value="Search on tags"/>';
            echo '&nbsp<input type="submit" value="Search" />';
            echo '&nbsp;or&nbsp;<a href="'.$vars['url'].'pg/izap_videos/'.$_SESSION['user']->username.'/add">'.elgg_echo('izap_videos:add').'</a>';
        echo '</form>';
    echo '</div>';
    
    //include $CONFIG->pluginspath . 'izap_videos/classes/video_feed.php';
    if(is_array($vars['entities']) && count($vars['entities']) > 0) {
        foreach ($vars['entities'] as $entity) {

        $video_type = $entity->videotype;
        $video_src = $entity->videosrc;
        $width = 540;
        $height = 324;
        $video_autoplay = (!$entity->autoplay) ? 0 : 1;
        $player_path = '';
            if(!$video_src)
            {
                $video_src = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?id=" . $entity->getGUID();
                $player_path = "/mod/izap_videos/player/izap_player.swf";
                $border_color1 = get_plugin_setting('izapBorderColor1', 'izap_videos');
                $border_color2 = get_plugin_setting('izapBorderColor2', 'izap_videos');
                $bar_color = get_plugin_setting('izapBarColor', 'izap_videos');
                $options = '';
                if(isset($border_color1) && !empty($border_color1))
                    $options .= '&bgcolor1=' . $border_color1;
                if(isset($border_color2) && !empty($border_color2))
                    $options .= '&bgcolor2=' . $border_color2;
                if(isset($bar_color) && !empty($bar_color))
                    $options .= '&playercolor=' . $bar_color;
            }
        $izap_video = new izapVideo();
        $player = $izap_video->izap_video_object($video_type, $video_src, $width, $height, $video_autoplay, $player_path, $options);

        //$player .= '<h2 align="center">'.$entity->title.'</h2>';


            $thumb = $CONFIG->wwwroot . $entity->imagesrc;
            if(substr_count($entity->imagesrc,"images") == 0)
                $thumb = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $entity->getGUID();

            $image = '<img src="'.$thumb.'" height="90" width="90">';

            $content = htmlentities($player, ENT_COMPAT, "UTF-8");

            $friendlytime = friendly_time($entity->time_created);
            $icon = '<a href="javascript: elggUpdateContent(\''.$content.'\',\''.$vars['internalname'].'\');">'.$image.'</a>';

            $info = '<a href="javascript: elggUpdateContent(\''.$content.'\',\''.$vars['internalname'].'\');">' . $entity->title . '</a>';
            //echo elgg_view_listing($icon,$info);
            ?>
            <div class="embedThumbs contentWrapper" title="<?php echo $entity->title?>">
                <a href="<?php echo 'javascript: elggUpdateContent(\''.$content.'\',\''.$vars['internalname'].'\');';?>">
                    <?php echo $image;?>
                    <div><?php echo substr($entity->title, 0, 8)?>...</div>
                </a>
            </div>

            <?php
       }
    } else {
        echo '<div class="contentWrapper">'.elgg_echo('izap_videos:noTagVideo').'</div>';
    }
   ?>
   <div class="clearfloat"></div>
</div>

<script>
    function video_search() {
        search = $('#search').val();
        $('#videoIcons').load('<?php echo $vars['url'] . 'mod/izap_videos/embed.php?search='?>'+encodeURI(search));
    }
</script>