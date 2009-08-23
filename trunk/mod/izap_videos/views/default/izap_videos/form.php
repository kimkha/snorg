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

// get page owner
$page_owner = page_owner_entity();

// set default all off
$UPLOADurl = FALSE;
$UPLOADfile = FALSE;
$UPLOADembed = FALSE;

// load plugin settings
$uploadMethodURL = get_plugin_setting('izapUploadOptionURL', 'izap_videos');
if($uploadMethodURL == 'OFFSERVER_ON'){
  $UPLOADurl = TRUE;
  if(!$fileSelectedclass && !$embedSelectedclass){
    $urlSelectedclass = 'selected';
    $videoType = 'IZAP_URL';
  }
}

$uploadMethodUPLOAD = get_plugin_setting('izapUploadOptionUPLOAD', 'izap_videos');
if($uploadMethodUPLOAD == 'ONSERVER_ON'){
  $UPLOADfile = TRUE;
  if(!$urlSelectedclass && !$embedSelectedclass){
    $fileSelectedclass = 'selected';
    $videoType = 'IZAP_FILE';
  }
}

$uploadMethodEMBED = get_plugin_setting('izapUploadOptionEMBED', 'izap_videos');
if($uploadMethodEMBED == 'EMBED_ON'){
  $UPLOADembed = TRUE;
  if(!$fileSelectedclass && !$urlSelectedclass){
    $embedSelectedclass = 'selected';
    $videoType = 'IZAP_EMBED';
  }
}

$maxFileSize = (int) get_plugin_setting('izapMaxFileSize', 'izap_videos');

	if(isset($vars['entity']))
	{
		$izap_videos_title = $vars['entity']->title;
		$izap_videos_description = $vars['entity']->description;
		if(is_array($vars['entity']->tags))
      $izap_videos_tags = implode(', ',$vars['entity']->tags);
    else
      $izap_videos_tags = $vars['entity']->tags;
		$izap_vidoesautoplay = (int) $vars['entity']->autoplay;
		$izap_videosaccessid = $vars['entity']->access_id;

    if($vars['entity']->videotype == 'embed')
      $izap_embed_code = $vars['entity']->videosrc;

		$action = 'izap_videos/edit';
	}
	else
	{
    $previousData = $_SESSION['postedData'];

    $fileChecked = '';
    $urlChecked = 'CHECKED';
    $izap_videos_url = $previousData['izap_videosurl'];
    $izap_embed_code = $previousData['izap_embed_code'];
		$izap_videos_title = $previousData['izap_videostitle'];
		$izap_videos_description = $previousData['izap_videosdescription'];
		$izap_videos_tags = $previousData['izap_videostags'];
		$izap_vidoesautoplay = 0;
		$izap_videosaccessid = ACCESS_PUBLIC;
		$action = 'izap_videos/add';

    if(isset($previousData['inputTab'])){
      unset($urlSelectedclass);
      unset($fileSelectedclass);
      unset($embedSelectedclass);
    
    switch ($previousData['inputTab']) {
      case 'IZAP_URL':
        $urlSelectedclass = 'selected';
        $videoType = 'IZAP_URL';
      break;

      case 'IZAP_FILE':
        $fileSelectedclass = 'selected';
        $videoType = 'IZAP_FILE';
      break;

      case 'IZAP_EMBED':
        $embedSelectedclass = 'selected';
        $videoType = 'IZAP_EMBED';
      break;

      }
    }
  }


// lets start the form fields
if($action != 'izap_videos/edit'){
  if($UPLOADurl)
    $formFields['izapVideoUrl'] = array('type' => 'text', 'value' => $izap_videos_url);
  if($UPLOADfile)
    $formFields['izapVideoFile'] = array('type' => 'file', 'value' => '');
  if($UPLOADembed){
    $formFields['izapVideoEmbed'] = array('type' => 'longtext', 'value' => $izap_embed_code);
    $formFields['izapVideoEmbedImage'] = array('type' => 'file', 'value' => '');
  }
}elseif($vars['entity']->videotype == 'embed'){
  if($UPLOADembed){
    $formFields['izapVideoEmbed'] = array('type' => 'longtext', 'value' => $izap_embed_code);
    $formFields['izapVideoEmbedImage'] = array('type' => 'file', 'value' => '');
  }
}

$formExtraFields = array(
    'izapVideoTitle' => array('type' => 'text', 'value' => $izap_videos_title),
    'izapVideoDescription' => array('type' => 'longtext', 'value' => $izap_videos_description),
    'izapVideoTags' => array('type' => 'tags', 'value' => $izap_videos_tags),
    'izapVideoAccess' => array('type' => 'access', 'value' => $izap_videosaccessid),
    'izapPageOwner' => array('type' => 'hidden', 'value' => $page_owner->guid),
    'izapVideoId' => array('type' => 'hidden', 'value' => $vars['entity']->guid),
    'izapVideoType' => array('type' => 'hidden', 'value' => $videoType),
  );

// show form only if admin has enabled some thing
if(is_array($formFields) || $action == 'izap_videos/edit') {
  // mrege fields
  if(is_array($formFields))
    $formFields = array_merge($formFields, $formExtraFields);
  else
    $formFields = $formExtraFields;

  foreach ($formFields as $name => $value) {
    if($value['type'] != 'hidden'){
      $tmpForm .= '<p id="id_'.$name.'"><label>';
      $tmpForm .= elgg_echo('izap_videos:form:'.$name.'') . '<br />';
      $tmpForm .= elgg_view('input/'.$value['type'].'', array(
                                                   'internalname' => $name,
                                                   'value' => $value['value'],
                                                    ));
       if($name == 'izapVideoFile'){
         $tmpForm .= '&nbsp;<b>' . sprintf(elgg_echo('izap_videos:maxFileSize'), $maxFileSize) . '</b>';
       }

      $tmpForm .= '</label></p>';
    }else{
      $tmpForm .= elgg_view('input/'.$value['type'].'', array(
                                                   'internalname' => $name,
                                                   'value' => $value['value'],
                                                   'js' => 'id="hidden_' . $name . '"',
                                                    ));
    }
  }

  $tmpForm .= elgg_view('categories', $vars);
  $tmpForm .= elgg_view('input/submit', array('value' => elgg_echo('izap_videos:save')));
  $form = elgg_view('input/form', array('body' => $tmpForm, 'action' => $vars['url'] . 'action/' . $action, 'enctype' => 'multipart/form-data'));
  unset($_SESSION['postedData']);
}else{
  $form = '<p align="center"><b>' . elgg_echo('izap_videos:noOptionSelected') . '</b></p>';
}
?>

<div class="contentWrapper">
<?php if($action != 'izap_videos/edit') {?>
<div id="elgg_horizontal_tabbed_nav">
  <ul>
  <?php if($UPLOADurl){?>
    <li class="<?php echo $urlSelectedclass;?>" id="formUrl_izap_videos"><a href=""><?php echo elgg_echo('izap_videos:form:enterUrl')?></a></li>
  <?php } if($UPLOADfile){?>
    <li class="<?php echo $fileSelectedclass;?>" id="formUpload_izap_videos"><a href=""><?php echo elgg_echo('izap_videos:form:upload')?></a></li>
  <?php } if($UPLOADembed){?>
    <li class="<?php echo $embedSelectedclass;?>" id="formEmbed_izap_videos"><a href=""><?php echo elgg_echo('izap_videos:form:embedCode')?></a></li>
  <?php }?>
  </ul>
</div>
<?php }?>
<div id="inputArea_izap_videos"></div>
<?php echo $form?>
</div>

<script>
  function removeEditor(){
    toggleEditor('izapVideoEmbed');
   }
   
  $(document).ready(function(){

    
    <?php if($UPLOADembed){?>
      setTimeout(removeEditor, 1000);
    <?php } ?>
  // this all will only work if it is not edit form
 <?php if($action != 'izap_videos/edit') {?>
   // check what is currently selected
   <?php if($urlSelectedclass){?>
       $('#id_izapVideoFile').hide();
       $('#id_izapVideoEmbed').hide();
       $('#id_izapVideoEmbedImage').hide();
       $('a[href="javascript:toggleEditor(\'izapVideoEmbed\');"]').hide();
   <?php }?>

   <?php if($fileSelectedclass){?>
       $('#id_izapVideoUrl').hide();
       $('#id_izapVideoEmbed').hide();
       $('#id_izapVideoEmbedImage').hide();
       $('a[href="javascript:toggleEditor(\'izapVideoEmbed\');"]').hide();
   <?php }?>

   <?php if($embedSelectedclass){?>
       $('#id_izapVideoUrl').hide();
       $('#id_izapVideoFile').hide();
   <?php }?>

      // click event for the url tab
     $('#formUrl_izap_videos').click(function(){
       $('#id_izapVideoFile').hide();
       $('#id_izapVideoEmbed').hide();
       $('#id_izapVideoEmbedImage').hide();
       $('a[href="javascript:toggleEditor(\'izapVideoEmbed\');"]').hide();
       $('#formUpload_izap_videos').removeClass('selected');
       $('#formEmbed_izap_videos').removeClass('selected');
       $('#formUrl_izap_videos').addClass('selected');
       $('#hidden_izapVideoType').val('IZAP_URL');
       $('#id_izapVideoUrl').show();
       return false;
     });

     // click event for the upload tab
     $('#formUpload_izap_videos').click(function(){
       $('#id_izapVideoUrl').hide();
       $('#id_izapVideoEmbed').hide();
       $('#id_izapVideoEmbedImage').hide();
       $('a[href="javascript:toggleEditor(\'izapVideoEmbed\');"]').hide();
       $('#formUrl_izap_videos').removeClass('selected');
       $('#formEmbed_izap_videos').removeClass('selected');
       $('#formUpload_izap_videos').addClass('selected');
       $('#hidden_izapVideoType').val('IZAP_FILE');
       $('#id_izapVideoFile').show();
       return false;
     });

     // click event for the embed tab
     $('#formEmbed_izap_videos').click(function(){
       $('#id_izapVideoFile').hide();
       $('#id_izapVideoUrl').hide();
       $('#formUpload_izap_videos').removeClass('selected');
       $('#formUrl_izap_videos').removeClass('selected');
       $('#formEmbed_izap_videos').addClass('selected');
       $('#hidden_izapVideoType').val('IZAP_EMBED');
       $('#id_izapVideoEmbed').show();
       $('a[href="javascript:toggleEditor(\'izapVideoEmbed\');"]').show();
       $('#id_izapVideoEmbedImage').show();
       return false;
     });
   <?php }?>
  });
</script>