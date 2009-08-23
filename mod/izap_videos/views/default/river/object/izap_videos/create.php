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

	 
	$item  = $vars['item'];
	
	$performed_by = get_entity($item->subject_guid); // $statement->getSubject();
	$object = get_entity($item->object_guid);
	$url = $object->getURL();
	$videoTitle .= '<a href="' . $url . '">' . $object->title . '</a>';
	$url = "<a href=\"{$performed_by->getURL()}\">{$performed_by->name}</a>";
	$string .= sprintf(elgg_echo('izap_videos:river:titled'),$url,$videoTitle);

	echo $string;