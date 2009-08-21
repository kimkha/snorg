<?php
	/**
	* 
	* Taskbar float upto page, be used to put something. 
	* 
	* @package snorg
	* @author KimKha
	* @copyright SNORG 2009
	* @version 0.1
	*/
if (isloggedin()) {
?>
<div id="elgg_taskbar">
	<div id="notification_taskbar">*</div>
	<div id="elggchat_toolbar_left" >
		<div id="elggchat_sessions_wrapper">
			<a href='javascript:floatChatWindow(-1);' title="Previous" style='float:left; display:none;'>&lt;&lt;</a>
			<div id='elggchat_sessions'> 
			</div>
			<a href='javascript:floatChatWindow(1);' title="Next" style='float:left; display:none;'>&gt;&gt;</a>
		</div>
		<div id="elggchat_friends">
			<a href="javascript:toggleFriendsPicker();"></a>
		</div>
		<div id="elggchat_friends_picker"></div>
	</div>
	
	<!--div id="toggle_elggchat_toolbar" class="toggle_elggchat_toolbar" onclick="toggleChatToolbar('slow')" title="<?php echo elgg_echo("elggchat:toolbar:minimize");?>"></div-->


</div> <!-- / Elgg Taskbar -->
<?php
	}
?>