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
<div id="elgg_taskbar"><div id="leftside_taskbar">
	<?php echo elgg_view('taskbar/extend', $vars); ?>
</div>
	<div id="elggchat_toolbar_left" >
		<div id="elggchat_friends">
			<a href="javascript:toggleFriendsPicker();"></a>
		</div>
		<div id="elggchat_friends_picker"></div>
		<div id="elggchat_sessions_wrapper">
			<a href='javascript:floatChatWindow(-1);' title="Previous" style='float:left; display:none;' id="elggchat_sessions_wrapper_previous"><span>&lt;&lt;</span></a>
			<div id='elggchat_sessions'> 
			</div>
			<a href='javascript:floatChatWindow(1);' title="Next" style='float:left; display:none;' id="elggchat_sessions_wrapper_next"><span>&gt;&gt;</span></a>
		</div>
	</div>
	
	<!--div id="toggle_elggchat_toolbar" class="toggle_elggchat_toolbar" onclick="toggleChatToolbar('slow')" title="<?php echo elgg_echo("elggchat:toolbar:minimize");?>"></div-->
	


</div> <!-- / Elgg Taskbar -->
<?php
	}
?>