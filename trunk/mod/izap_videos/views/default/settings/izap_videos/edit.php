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

  $plugin = $vars['entity'];
	 
	$izapBorderColor1 = $plugin->izapBorderColor1;
	$izapBorderColor2 = $plugin->izapBorderColor2;
	$izapBarColor = $plugin->izapBarColor;

  // default value for the uploading option
  $izapUploadOptionURL = $plugin->izapUploadOptionURL;
	if(!$izapUploadOptionURL)
	{
    $plugin->izapUploadOptionURL = 'OFFSERVER_ON';
		$izapUploadOptionURL = $plugin->izapUploadOptionURL;
	}

  $izapUploadOptionUPLOAD = $plugin->izapUploadOptionUPLOAD;
	if(!$izapUploadOptionUPLOAD)
	{
    $plugin->izapUploadOptionUPLOAD = 'ONSERVER_ON';
		$izapUploadOptionUPLOAD = $plugin->izapUploadOptionUPLOAD;
	}

  $izapUploadOptionEMBED = $plugin->izapUploadOptionEMBED;
	if(!$izapUploadOptionEMBED)
	{
    $plugin->izapUploadOptionEMBED = 'EMBED_ON';
		$izapUploadOptionEMBED = $plugin->izapUploadOptionEMBED;
	}

  // default PHP Interpreter Command
  $PHPInterpreter = $plugin->izapPhpInterpreter;
  $PHPInterpreterPath = '/usr/bin/php';
  if(!$PHPInterpreter){
      $plugin->izapPhpInterpreter = $PHPInterpreterPath;
      $PHPInterpreter = $plugin->izapPhpInterpreter;
  }

  // default video converting command
  $VideoConvert = $plugin->izapVideoCommand;
  $convertCommand = '/usr/bin/ffmpeg -y -i [inputVideoPath] -vcodec libx264 -vpre hq  -b 300k  -bt 300k  -acodec libfaac  -ar 22050  -ab 48k  [outputVideoPath]';
  if(!$VideoConvert){
      $plugin->izapVideoCommand = $convertCommand;
      $VideoConvert = $plugin->izapVideoCommand;
  }

  // default video thumbnal command
  $VideoThumb = $plugin->izapVideoThumb;
  $thumbCommand = '/usr/bin/ffmpeg -y -i [inputVideoPath] -vframes 1 -ss 00:00:10 -an -vcodec png -f rawvideo -s 320x240 [outputImage]';
  if(!$VideoThumb){
      $plugin->izapVideoThumb = $thumbCommand;
      $VideoThumb = $plugin->izapVideoThumb;
  }

  // default file size 20 Mb
  $maxFileSize = $plugin->izapMaxFileSize;
  if(!(int)$maxFileSize){
      $plugin->izapMaxFileSize = 20;
      $maxFileSize = $plugin->izapMaxFileSize;
  }

  // default value for the index page option
  $izapIndexPageWidget = $plugin->izapIndexPageWidget;
  if(!$izapIndexPageWidget){
    $plugin->izapIndexPageWidget = 'yes';
    $izapIndexPageWidget = $plugin->izapIndexPageWidget;
  }
  
	$label_izapUploadOptionURL = sprintf(elgg_echo('izap_videos:izapUploadOption'), 'Off server videos (Supporting youtube, vimeo & veoh)');
  $label_izapUploadOptionUPLOAD = sprintf(elgg_echo('izap_videos:izapUploadOption'), 'On server videos (Supporting 3gp, avi, mp4, flv)');
  $label_izapUploadOptionEMBED = sprintf(elgg_echo('izap_videos:izapUploadOption'), 'Embed code');
	$label_izapBorderColor1 = elgg_echo('izap_videos:izapBorderColor1');
	$label_izapBorderColor2 = elgg_echo('izap_videos:izapBorderColor2');
	$label_izapBarColor = elgg_echo('izap_videos:izapBarColor');
  $label_izapPhpInterpreter = elgg_echo('izap_videos:izapPhpInterpreter');
  $label_izapFfmpegConvertCommand = elgg_echo('izap_videos:izapFfmpegConvert');
  $label_izapFfmpegImageCommand = elgg_echo('izap_videos:izapFfmpegImage');
  $label_izapMaxFileSize = elgg_echo('izap_videos:enterMaxFileSize');
  $label_izapIndexPageWidget = elgg_echo('izap_videos:izapIndexPageWidget');
  
$izapUploadOptionsURL = elgg_view('input/radio', array(
                                'internalname' => 'params[izapUploadOptionURL]',
                                'options' => array(
                                    'Enable' => 'OFFSERVER_ON',
                                    'Disable' => 'OFFSERVER_OFF',
                                    ),
                                'value' => $izapUploadOptionURL));

$izapUploadOptionsUPLOAD = elgg_view('input/radio', array(
                                'internalname' => 'params[izapUploadOptionUPLOAD]',
                                'options' => array(
                                    'Enable' => 'ONSERVER_ON',
                                    'Disable' => 'ONSERVER_OFF',
                                    ),
                                'value' => $izapUploadOptionUPLOAD));

$izapUploadOptionsEMBED = elgg_view('input/radio', array(
                                'internalname' => 'params[izapUploadOptionEMBED]',
                                'options' => array(
                                    'Enable' => 'EMBED_ON',
                                    'Disable' => 'EMBED_OFF',
                                      ),
                                'value' => $izapUploadOptionEMBED));

	$barcolor_text = elgg_view('input/text', array('internalname' => 'params[izapBarColor]', 'value' => $izapBarColor));
	$bordercolor_text1 = elgg_view('input/text', array('internalname' => 'params[izapBorderColor1]', 'value' => $izapBorderColor1));
	$bordercolor_text2 = elgg_view('input/text', array('internalname' => 'params[izapBorderColor2]', 'value' => $izapBorderColor2));

  $text_izapPhpInterpreter = elgg_view('input/text', array('internalname' => 'params[izapPhpInterpreter]', 'value' => $PHPInterpreter));
  $text_izapFfmpegConvertCommand = elgg_view('input/text', array('internalname' => 'params[izapVideoCommand]', 'value' => $VideoConvert));
  $text_izapFfmpegImageCommand = elgg_view('input/text', array('internalname' => 'params[izapVideoThumb]', 'value' => $VideoThumb));

  $text_izapMaxFileSize = elgg_view('input/text', array('internalname' => 'params[izapMaxFileSize]', 'value' => $maxFileSize));
  $radio_izapIndexPageWidget = elgg_view('input/radio', array('internalname' => 'params[izapIndexPageWidget]', 'value' => $izapIndexPageWidget, 'options' => array('Yes' => 'yes', 'No' => 'no')));
?>
<p style="color:red;">If you choose the <b>All</b> or <b>On server videos</b>, then you have to specify the <b>PHP interpreter path</b> and <b>FFMPEG interpreter path</b>.</p><br />

<p><label><?php echo $label_izapUploadOptionURL?><br /><?php echo $izapUploadOptionsURL?></label></p><br />
<p><label><?php echo $label_izapUploadOptionUPLOAD?><br /><?php echo $izapUploadOptionsUPLOAD?></label></p><br />
<p><label><?php echo $label_izapUploadOptionEMBED?><br /><?php echo $izapUploadOptionsEMBED?></label></p><br />

<p><label><?php echo $label_izapBorderColor1?><br /><?php echo $bordercolor_text1?></label></p><br />
<p><label><?php echo $label_izapBorderColor2?><br /><?php echo $bordercolor_text2?></label></p><br />
<p><label><?php echo $label_izapBarColor?><br /><?php echo $barcolor_text?></label></p><br />

<p><label><?php echo $label_izapPhpInterpreter?><br /><?php echo $text_izapPhpInterpreter?></label></p><br />
<p><label><?php echo $label_izapFfmpegConvertCommand?><br /><?php echo $text_izapFfmpegConvertCommand?></label><i><?php echo $convertCommand;?></i></p><br />
<p><label><?php echo $label_izapFfmpegImageCommand?><br /><?php echo $text_izapFfmpegImageCommand?></label><i><?php echo $thumbCommand;?></i></p><br />

<p><label><?php echo $label_izapMaxFileSize?><br /><?php echo $text_izapMaxFileSize?></label></p><br />
<p><label><?php echo $label_izapIndexPageWidget?><br /></label><span class="izap-input-radio"><?php echo $radio_izapIndexPageWidget?></span></p><br />
