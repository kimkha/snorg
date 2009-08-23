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

// lets include all the required files
include $CONFIG->pluginspath . 'izap_videos/classes/class.curl.php';
include $CONFIG->pluginspath . 'izap_videos/classes/convert.php';
include $CONFIG->pluginspath . 'izap_videos/classes/getFeed.php';
include $CONFIG->pluginspath . 'izap_videos/classes/video_feed.php';

/**
 * this function get all the videos for a user or all users
 * 
 * @param int $ownerGuid id of the user to get videos for
 * @param boolean $count Do u want the total or videos ? :)
 * @return videos or false
 */
function izapGetAllVideos_izap_videos($ownerGuid = 0, $count = FALSE, $izapVideoType = 'object', $izapSubtype = 'izap_videos') {
  $videos = get_entities($izapVideoType, $izapSubtype, $ownerGuid, '', 0);
  return $videos;
}

/**
 * this function updates the view for videos for every play
 * @global <type> $CONFIG
 * @param int $videoId guid of video to work on
 * @param int $lastViews
 */
function izapUpdateViews_izap_videos($videoId, $lastViews = 0){
  global $CONFIG;

  if((int) $videoId){
    $newViews = ((int) $lastViews) + 1;
    $valueId = add_metastring($newViews);
    $row = get_data("SELECT m.id FROM " . $CONFIG->dbprefix . "metadata AS m JOIN " . $CONFIG->dbprefix . "entities e ON e.guid = m.entity_guid JOIN " . $CONFIG->dbprefix . "metastrings ms ON ms.id = m.name_id WHERE e.guid = '" . $videoId . "' AND ms.string = 'views'");
    $mdId = $row[0]->id;
    $in = update_data("UPDATE " . $CONFIG->dbprefix . "metadata SET value_id = '" . $valueId . "' WHERE id = '" . $mdId . "'");
  }
}

/**
 * this function will return the player
 * 
 * @global <type> $CONFIG
 * @param string $videoType video type like vimeo etc
 * @param string $videoSrc video source
 * @param int $autoPlay
 * @param int $width
 * @param int $height
 * @return string full player object
 */
function izapGetPlayer_izap_videos($videoType, $videoSrc, $autoPlay = 0, $width = 640, $height = 385){
  global $CONFIG;
  if($videoType == 'uploaded') {
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
	$player = $izap_video->izap_video_object($videoType, $videoSrc, $width, $height, (int)$autoPlay, $CONFIG->izap_videos['playerPath'], $options);

  return $player;
}

/**
 * this function will check that is the given id is of izap_videos
 * @param int $videoId video id
 * @return video entity or FALSE
 */
function izapVideoCheck_izap_videos($videoId, $canEditCheck = FALSE) {
  $videoId = (int) $videoId;
  if($videoId){
    $video = get_entity($videoId);

      if($canEditCheck && !$video->canEdit())
      forward();

    $subtype = get_subtype_from_id($video->subtype);
    if($subtype == 'izap_videos')
      return $video;
  }

  register_error(elgg_echo('izap_videos:noVideo'));
  forward();
}

/**
 * this function checks the supported videos 
 * @global <type> $CONFIG
 * @param string $videoFileName video name with extension
 * @return boolean TRUE if supported else FALSE
 */
function izapSupportedVideos_izap_videos($videoFileName) {
  global $CONFIG;
  $supportedFormats = $CONFIG->izap_videos['allowedExtensions'];
  $extension = strtolower(end(explode('.', $videoFileName)));
  if(in_array($extension, $supportedFormats))
    return TRUE;
    
  return FALSE;
}

/**
 * this function will check the max upload limit for file
 * 
 * @param integer $fileSize in Mb
 * @return boolean true if everything is ok else false
 */
function izapCheckFileSize_izap_videos($fileSize) {
  $maxFileSize = (int) get_plugin_setting('izapMaxFileSize', 'izap_videos');
  $maxSizeInBytes = $maxFileSize*1024*1024;
  
  if($fileSize > $maxSizeInBytes)
    return FALSE;

  return TRUE;
}
/**
 * this function saves the entry for futher processing
 * @param string $file main filepath
 * @param int $videoId video guid
 * @param int $ownerGuid owner guid
 * @param int $accessId access id for entry to save (must be kept public)
 */
function izapSaveFileInfoForConverting_izap_videos($file, $video, $accessId = 2){
// this will not let save any thing if there is no file to convert
if($file == '')
  return ;
  
  $queue = new ElggObject();
  $queue->subtype = 'izapVideoQueue';
  $queue->access_id = ACCESS_PUBLIC;
  $queue->mainFile = $file;
  $queue->videoId = $video->guid;
  $queue->videoTitle = $video->title;
  $queue->videoUrl = $video->getUrl();
  $queue->videoOwner = $video->owner_guid;
  $queue->videoAccess = $accessId;
  $queue->save();

  // trigger the queue after upload
  izapTrigger_izap_videos();
}

/**
 * this fucntion actually converts the video
 * @param string $file file loacation
 * @param int $videoId video guid
 * @param int $ownerGuid video owner guid
 * @param int $accessId access id
 * @return boolean
 */
function izapConvertVideo_izap_videos($file, $videoId, $videoTitle, $videoUrl, $ownerGuid, $accessId = 2) {
  global $CONFIG;
  $return = FALSE;

  // works only if we have the input file
  if($file != '' && file_exists($file)){

    // now convert video
    $video = new izapConvert($file);
    $videofile = $video->convert();
    //$videoimage = $video->photo();

    // check if every this is ok
    if(!is_array($videofile)){

    // if every thing is ok then get back values to save
    $file_values = $video->getValues();
    $izap_videofile = 'izap_videos/uploaded/' . $file_values['filename'];
    //$izap_imagefile = 'izap_videos/uploaded/' . $file_values['imagename'];
    $izap_origfile = 'izap_videos/uploaded/' . $file_values['origname'];

      $filehandler = new ElggFile();
      $filehandler->owner_guid = $ownerGuid;
      $filehandler->setFilename($izap_videofile);
      $filehandler->open("write");
      $filehandler->write($file_values['filecontent']);

      $filehandler->setFilename($izap_origfile);
      $filehandler->open("write");
      $filehandler->write($file_values['origcontent']);

//      $filehandler->setFilename($izap_imagefile);
//      $filehandler->open("write");
//      $filehandler->write($file_values['imagecontent']);

      $filehandler->close();


      //$saveArray['imagesrc'] = $izap_imagefile;
      $saveArray['videofile'] = $izap_videofile;
      $saveArray['orignalfile'] = $izap_origfile;
      $saveArray['converted'] = 'yes';
      
      $return = izapUpdateObject_izap_videos($videoId, $saveArray);
      if($return){
        // notify the user if the video is saved properly
        notify_user($ownerGuid,
                  $CONFIG->site_guid,
                  elgg_echo('izap_videos:notifySub:videoConverted'),
                  sprintf(elgg_echo('izap_videos:notifyMsg:videoConverted'), $videoTitle, $videoUrl)
                  );
      }
      return $return;
    }else{
      $errorReason = $videofile['message'];
    }
  }else{
    $errorReason = elgg_echo('izap_videos:fileNotFound');
  }
  $adminGuid = izapGetSiteAdmin_izap_videos(TRUE);

  // notify admin
  notify_user($adminGuid,
                  $CONFIG->site_guid,
                  elgg_echo('izap_videos:notifySub:videoNotConverted'),
                  sprintf(elgg_echo('izap_videos:notifyAdminMsg:videoNotConverted'), $errorReason)
                  );
  // notify user
  notify_user($ownerGuid,
                  $CONFIG->site_guid,
                  elgg_echo('izap_videos:notifySub:videoNotConverted'),
                  elgg_echo('izap_videos:notifyUserMsg:videoNotConverted')
                  );
  return $return;
}

/**
 * checks if video is converted or not
 * @param object $videoEntity video
 * @return boolean
 */
function izapVideoNotConverted_izap_videos($videoEntity) {
  if($videoEntity->converted == 'no')
    return TRUE;

  return FALSE;
}

/**
 * this function updates the metadata for any entity, it overrides the canEdit
 * permission for all entities
 *
 * @global object $CONFIG global config object
 * @param integer $entity_guid guid of the entity
 * @param array $mainArray
 * @return TRUE | FALSE
 */
function izapUpdateObject_izap_videos($entity_guid, $mainArray = array()) {
    
    global $CONFIG;
        foreach ($mainArray as $name => $value) {
            $existing = get_data_row("SELECT * from {$CONFIG->dbprefix}metadata WHERE entity_guid = $entity_guid and name_id=" . add_metastring($name) . " limit 1");
            if (($existing))
            {
                $nameId = add_metastring($name);
                if(!$nameId) return FALSE;

                $valueId = add_metastring($value);
                if(!$valueId) return FALSE;

                $id = $existing->id;
                $result = izapUpdateMetadata_izap_videos($id, $nameId, $valueId);

                if (!$result) return false;
            }else {
              return FALSE;
            }
        }
        return TRUE;
}

/**
 * this function actully updates the metadata in the database
 *
 * @global object $CONFIG global CONFIG object
 * @param integer $id
 * @param integer $nameId
 * @param integer $valueId
 * @return TRUE | FALSE
 */
function izapUpdateMetadata_izap_videos($id, $nameId, $valueId) {
    global $CONFIG;
    $result = update_data("UPDATE {$CONFIG->dbprefix}metadata set value_id='$valueId' where id=$id and name_id='$nameId'");
        if ($result!==false) {
            $obj = get_metadata($id);
            if (trigger_elgg_event('update', 'metadata', $obj)) {
                return true;
            }
        }
    return $result;
}

/**
 * this function deletes video queue entity from the elgg
 * 
 * @global global $CONFIG
 * @param int $id guid of queue
 * @return result if deleted else FALSE
 */
function izapDeleteQueueObject_izap_videos($queueEntity) {
  global $CONFIG;

  if(file_exists($queueEntity->mainFile))
    @unlink($queueEntity->mainFile);

$tmpVideoFile = substr($queueEntity->mainFile, 0, -4) . '_c.flv';
$tmpImageFile = substr($queueEntity->mainFile, 0, -4) . '_i.png';

  if(file_exists($tmpVideoFile))
    @unlink($tmpVideoFile);

  if(file_exists($tmpImageFile))
    @unlink($tmpImageFile);

  $result = izapDeleteObject_izap_videos($queueEntity->guid);
  return $result;
}

/**
 * this function deletes the video
 * 
 * @param int $videoId guid of the video
 * @return result if deleted or FALSE if not
 */
function izapDeleteVideo_izap_videos($videoId) {
  $return = izapDeleteObject_izap_videos($videoId);

  return $return;
}

/**
 * this function triggers the queue
 * 
 * @global <type> $CONFIG 
 */
function izapTrigger_izap_videos(){
  global $CONFIG;
  $PHPpath = izapGetPhpPath_izap_videos();
  if(!izapIsQueueRunning_izap_videos()){
    set_plugin_setting('isQueueRunning', 'yes', 'izap_videos');
    exec($PHPpath . ' ' . $CONFIG->pluginspath . 'izap_videos/izap_convert_video.php izap web > /dev/null 2>&1 &');
  }
}

/**
 * this function checks if the queue is running or not
 * 
 * @return boolean TRUE if yes or FALSE if no
 */
function izapIsQueueRunning_izap_videos() {
  $status = get_plugin_setting('isQueueRunning', 'izap_videos');
  if(!$status)
  set_plugin_setting('isQueueRunning', 'no', 'izap_videos');
  
  if($status == 'yes')
    return TRUE;
  else
    return FALSE;

}

/**
 * this function gives the path of PHP
 * 
 * @return string path
 */
function izapGetPhpPath_izap_videos() {
  $path = get_plugin_setting('izapPhpInterpreter', 'izap_videos');
  $path = html_entity_decode($path);
  if(!$path)
    $path = '';
  return $path;
}

/**
 * this function gives the FFmpeg video converting command
 *
 * @return string path
 */
function izapGetFfmpegVideoConvertCommand_izap_videos() {
  $path = get_plugin_setting('izapVideoCommand', 'izap_videos');
  $path = html_entity_decode($path);
  if(!$path)
    $path = '';
  return $path;
}

/**
 * this function gives the FFmpeg video image command
 *
 * @return string path
 */
function izapGetFfmpegVideoImageCommand_izap_videos() {
  $path = get_plugin_setting('izapVideoThumb', 'izap_videos');
  $path = html_entity_decode($path);
  if(!$path)
    $path = '';
  return $path;
}

//function izapEnableEntity_izap_videos($videoId) {
//  global $CONFIG;
//  $result = update_data("UPDATE {$CONFIG->dbprefix}entities set enabled='yes' where guid={$videoId}");
//  return $result;
//}

/**
 * this function checks the required plugin setting according to the options selected
 * 
 * and notifies the admin
 * @param <type> $msg
 * @return <type> 
 */
function izapCheckPluginSettings_izap_videos($msg = false) {
  // get plugin setting
  $uploadMethodUPLOAD = get_plugin_setting('izapUploadOptionUPLOAD', 'izap_videos');
    if($uploadMethodUPLOAD == 'ONSERVER_ON'){
      if(izapGetPhpPath_izap_videos() == '' || izapGetFfmpegVideoConvertCommand_izap_videos() == '' || izapGetFfmpegVideoImageCommand_izap_videos() == ''){
        //echo 'i am here';
        // unsets all the previously set error, other wise elgg sets lots and lots of error :P
        if(isset($_SESSION['msg']['errors'])){
          foreach ($_SESSION['msg']['errors'] as $key => $value) {
            if($value == elgg_echo('izap_videos:error:pluginSettings'))
              unset($_SESSION['msg']['errors'][$key]);
          }
        }
        // now set the new error
        if($msg)
          register_error(elgg_echo('izap_videos:error:pluginSettings'));

        return FALSE;
      }
    }
    return TRUE;
}

/**
 * this function take the snapshot of video file
 * 
 * @param string $file video filepath
 * @return file path if converted else FALSE
 */
function izapTakePhoto_izap_videos($file) {
  $image = new izapConvert($file);
  if($image->photo()){
    $retValues = $image->getValues();
    
    if($retValues['imagename'] != '' && $retValues['imagecontent'] != ''){
      $filehandler = new ElggFile();

      $filehandler->setFilename('izap_videos/uploaded/' . $retValues['imagename']);
      $filehandler->open("write");
      $filehandler->write($retValues['imagecontent']);

      $thumb = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(), 120, 90);
      $filehandler->setFilename('izap_videos/uploaded/' . $retValues['imagename']);
      $filehandler->open("write");
      $filehandler->write($thumb);

      $filehandler->close();

      return 'izap_videos/uploaded/' . $retValues['imagename'];
    }
  }
  return FALSE;
}

/**
 * grants the delete access
 * 
 * @param <type> $functionName
 */
function izapGetEntityDeleteAccess_izap_videos($functionName = 'izapEntityDeleteHook_izap_videos') {
  if(is_callable($functionName))
    register_plugin_hook('permissions_check', 'object', $functionName);
}

/**
 * remove the delete access
 * 
 * @global global $CONFIG
 * @param string $functionName 
 */
function izapRemoveEntityDeleteAccess_izap_videos($functionName = 'izapEntityDeleteHook_izap_videos') {
  global $CONFIG;
  if(isset($CONFIG->hooks['permissions_check']['object'])){
    foreach ($CONFIG->hooks['permissions_check']['object'] as $key => $hookFunction) {
      if($hookFunction == $functionName){
        unset($CONFIG->hooks['permissions_check']['object'][$key]);
      }
    }
  }
}

/**
 * elgg hook
 * 
 * @param <type> $hook
 * @param <type> $entity_type
 * @param <type> $returnvalue
 * @param <type> $params
 * @return <type>
 */
function izapEntityDeleteHook_izap_videos($hook, $entity_type, $returnvalue, $params) {
  return TRUE;
}

/**
 * this function deletes an object, (forcefully) ;)
 * 
 * @param <type> $guid
 * @return <type>
 */
function izapDeleteObject_izap_videos($guid) {
  izapGetEntityDeleteAccess_izap_videos();
    $return = delete_entity($guid, TRUE);
  izapRemoveEntityDeleteAccess_izap_videos();

  return $return;
}

/**
 * this function will tell if the admin wants to include the index page widget
 * 
 * @return boolean true for yes and false for no
 */
function izapIncludeIndexWidget_izap_videos() {
  $var = get_plugin_setting('izapIndexPageWidget', 'izap_videos');
  if(!$var)
    set_plugin_setting('izapIndexPageWidget', 'yes');

  if($var == 'no')
    return FALSE;

  return TRUE;
}

/**
 * this function copies the files from one location to another
 * 
 * @param int $sourceOwnerGuid guid of the file owner
 * @param string $sourceFile source file location
 * @param int $destinationOwnerGuid guid of new file owner, if not given then takes loggedin user id
 * @param string $destinationFile destination location, if blank then same as source
 */
function izapCopyFiles_izap_videos($sourceOwnerGuid, $sourceFile, $destinationOwnerGuid = 0, $destinationFile = '') {
  $filehandler = new ElggFile();

  $filehandler->owner_guid = $sourceOwnerGuid;
  $filehandler->setFilename($sourceFile);
  $filehandler->open('read');
  $sourceFileContents = $filehandler->grabFile();

  if($destinationFile == '')
    $destinationFile = $sourceFile;

  if(!$destinationOwnerGuid)
    $destinationOwnerGuid = get_loggedin_userid();

  $filehandler->owner_guid = $destinationOwnerGuid;
  $filehandler->setFilename($destinationFile);
  $filehandler->open('write');
  $filehandler->write($sourceFileContents);

  $filehandler->close();
}

/**
 * tmp function for fun
 *
 * @param array | object $vars
 */
function c($vars) {
  echo '<hr /><pre>';
    print_r($vars);
  echo '</pre><hr />';
}

/**
 * this function gets the site admin
 * 
 * @param boolean $guid if only guid is required
 * @return mix depends on the input and result
 */
function izapGetSiteAdmin_izap_videos($guid = FALSE) {
  $admin = get_entities_from_metadata('admin', 1, 'user', 0, 0, 1);
    if($admin[0]->admin || $admin[0]->siteadmin) {
      if($guid)
        return $admin[0]->guid;
      else
        return $admin[0];
    }

  return FALSE;
}