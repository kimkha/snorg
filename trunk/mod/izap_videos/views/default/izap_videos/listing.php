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

		
		$thumb = $CONFIG->wwwroot . $vars['entity']->imagesrc;
		if(substr_count($vars['entity']->imagesrc,"images") == 0)
			$thumb = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $vars['entity']->getGUID();
		
		$owner = $vars['entity']->getOwnerEntity();
		$friendlytime = friendly_time($vars['entity']->time_created);
		$icon = '<a href="' . $vars['entity']->getURL() . '"  class="screenshot" rel="' . $thumb . '"><img src="'.$thumb.'"></a>';
		
		$info = elgg_echo('videos') . " : ";
		$info .= '<a href="' . $vars['entity']->getURL() . '"  class="screenshot" rel="' . $thumb . '">' . $vars['entity']->title . '</a>';
		$info .= "<br />";
		$info .= "<a href=\"{$owner->getURL()}\">{$owner->name}</a> {$friendlytime}";
		echo elgg_view_listing($icon,$info);