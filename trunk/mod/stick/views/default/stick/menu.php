<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$list = get_user_objects(page_owner(), _STICK_COMMEND_SUBTYPE_, 1);
	$last = $list[0];
?>
	<p class="user_menu_stickuser1">
		<a href="<?php echo $vars['url']; ?>pg/stick/commend?id=<?php echo $last->guid; ?>"><?php echo elgg_echo('stick:user:view'); ?></a>	
	</p>