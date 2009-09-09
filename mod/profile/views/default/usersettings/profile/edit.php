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

	$allWallpost = get_register_wallpost();

	foreach ($allWallpost as $value) {
		$p = "Wallpost_".$value;
		$param = $vars['entity']->$p;
?>
<p>
	Wallpost setting for <b><?php echo $value; ?></b>:
	<select name="params[<?php echo $p; ?>]">
		<option value="enable" <?php if($param == "enable" || empty($param)) echo "selected='yes'"; ?>><?php echo elgg_echo("enable"); ?></option>
		<option value="disable" <?php if($param == "disable") echo "selected='yes'"; ?>><?php echo elgg_echo("disable"); ?></option>
	</select>
</p>
<?php
	}
?>
