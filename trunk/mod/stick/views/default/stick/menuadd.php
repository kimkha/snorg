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
	
?>
	<p class="user_menu_stickuser">
		<a href="<?php echo $vars['url']; ?>action/stick/commend?userid=<?php echo $vars['entity']->guid; ?>"><?php echo elgg_echo('stick:upostit'); ?></a>	
	</p>