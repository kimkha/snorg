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

	$embedselected = '';
	$uploadselected = '';
	if ($vars['tab'] == 'media') { 
		$embedselected = 'class="embed_tab_selected"'; 
	} elseif ($vars['tab'] == 'izap_videos') {
        $videosSelected = 'class="embed_tab_selected"'; 
    } else {
		$uploadselected = 'class="embed_tab_selected"';
	}
?>

<div id="embed_media_tabs">
	<ul>
		<li>
			<a href="#" <?php echo $embedselected; ?> onclick="javascript:$('.popup .content').load('<?php echo $vars['url'] . 'pg/embed/media'; ?>?internalname=<?php echo $vars['internalname']; ?>'); return false"><?php echo elgg_echo('embed:media'); ?></a>
		</li>
		<li>
			<a href="#" <?php echo $uploadselected; ?> onclick="javascript:$('.popup .content').load('<?php echo $vars['url'] . 'pg/embed/upload'; ?>?internalname=<?php echo $vars['internalname']; ?>'); return false"><?php echo elgg_echo('upload:media'); ?></a>
		</li>
        <li>
            <a href="#" <?php echo $videosSelected; ?> onclick="javascript:$('.popup .content').load('<?php echo $vars['url'] . 'pg/izap_videos/'.$_SESSION['username'].'/embed'; ?>?internalname=<?php echo $vars['internalname']; ?>'); return false"><?php echo elgg_echo('izap_videos:videoGal'); ?></a>
		</li>
	</ul>
</div>
<div class="clearfloat"></div>