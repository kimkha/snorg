<?php 
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Definition of the user settings
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	$enable_chat = $vars["entity"]->enableChat;

?>
<p>
	<?php echo elgg_echo("elggchat:usersettings:enable_chat"); ?>
	<select name="params[enableChat]">
		<option value="yes" <?php if($enable_chat == "yes" || empty($enable_chat)) echo "selected='yes'"; ?>><?php echo elgg_echo("option:yes"); ?></option>
		<option value="no"<?php if($enable_chat == "no") echo "selected='yes'"; ?>><?php echo elgg_echo("option:no"); ?></option>
	</select>
</p>