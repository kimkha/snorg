<?php

	/**
	 * Elgg messages topbar extender
	 * 
	 * @package ElggMessages
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	 
	 //need to be logged in to send a message
	 gatekeeper();

	//get unread messages
	
	$num_notification = count_unread_sitenotification();
	
	if($num_notification){
		$num = $num_notification;
	} else {
		$num = 0;
	}
?>
	<div id="notification_taskbar">
<?php
	if($num == 0){
?>
	<a href="javascript:openSitenotifcationDialog();" class="notification_name">Not</a>
	
<?php
    }else{
?>
    <a href="javascript:openSitenotifcationDialog();" class="notification_name">[<?php echo $num; ?>]</a>
	
<?php
    }
?>
	<div id="notification_wrapper"></div>
</div>