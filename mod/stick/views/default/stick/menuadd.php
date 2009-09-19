<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	$list = get_user_objects($vars['entity']->guid, _STICK_COMMEND_SUBTYPE_, 0);
	$n = count($list);
	$last = $list[0];
	
	if (!empty($last)) {
?>
	<p class="user_menu_stickuser1">
		<a href="<?php echo $vars['url']; ?>pg/stick/commend?id=<?php echo $last->guid; ?>"><?php echo elgg_echo('stick:user:view'); ?></a>	
	</p>
<?
	}
?>
	<p class="user_menu_stickuser">
		<a href="<?php echo $vars['url']; ?>action/stick/commend?userid=<?php echo $vars['entity']->guid; ?>"><?php echo elgg_echo('stick:upostit'); ?></a>	
	</p>