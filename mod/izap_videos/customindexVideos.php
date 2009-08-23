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
$type = get_input('type');

$tot = get_input('videosTOdisplay', 16);

switch ($type) {
    case 'latest':
        $videos = get_entities('object', 'izap_videos', 0, '', $tot);
        break;

    case 'views':
        $qry_topViews = "SELECT * FROM ".$CONFIG->dbprefix."metadata as m join ".$CONFIG->dbprefix."entities e on e.guid = m.entity_guid join ".$CONFIG->dbprefix."metastrings n on n.id = m.name_id join ".$CONFIG->dbprefix."metastrings v on v.id = m.value_id where e.subtype=".get_subtype_id('object', 'izap_videos')." AND n.string = 'views' AND ".get_access_sql_suffix('e')." ORDER BY cast(v.string AS SIGNED) DESC LIMIT 0, " . $tot;
		$videos = get_data($qry_topViews, 'entity_row_to_elggstar');
        break;

    case 'com':
        $qry_topCommented = "SELECT * FROM ".$CONFIG->dbprefix."annotations AS an JOIN ".$CONFIG->dbprefix."entities e ON e.guid = an.entity_guid WHERE e.subtype=".get_subtype_id('object', 'izap_videos')." AND ".get_access_sql_suffix('e')." GROUP BY an.entity_guid  ORDER BY count(an.entity_guid) DESC LIMIT 0, " . $tot;
        $videos = get_data($qry_topCommented, 'entity_row_to_elggstar');
        break;
    
    default:
        $videos = get_entities('object', 'izap_videos', 0, '', $tot);
        break;
}

if($videos){
  foreach ($videos as $entity) {
          $thumb = $CONFIG->wwwroot . $entity->imagesrc;
      if(substr_count($entity->imagesrc,"images") == 0)
        $thumb = $CONFIG->wwwroot . "mod/izap_videos/thumbs.php?what=image&id=" . $entity->getGUID();

         echo '<div class="customIndexIcon"><a href="'.$entity->getUrl().'"><img src="'.$thumb.'" width="40" height="40" alt="'.$entity->title.'" title="'.$entity->title.'"/></a></div>';
      }
  echo '<div class="clearfloat"></div>';
}
?>