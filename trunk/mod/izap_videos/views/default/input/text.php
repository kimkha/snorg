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
	
	$class = $vars['class'];
	if (!$class) $class = "input-text";
	
?><input type="text" <?php if ($vars['disabled']) echo ' disabled="yes" '; ?> <?php echo $vars['js']; ?> name="<?php echo $vars['internalname']; ?>" value="<?php echo htmlentities($vars['value'], null, 'UTF-8'); ?>" class="<?php echo $class ?>"/> 