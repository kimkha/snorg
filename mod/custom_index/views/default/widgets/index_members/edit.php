<?php

    /**
	 * Elgg Friends
	 * Friend widget options
	 * 
	 * @package ElggFriends
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	 
	 if(!isset($vars['entity']->num_display) || $vars['entity']->num_display <= 0)
	 	$vars['entity']->num_display = 10;
?>

<p>
		<?php echo elgg_echo("custom:members:num_display"); ?>:
		<select name="params[num_display]">
			<option value="5" <?php if($vars['entity']->num_display == 5) echo "SELECTED"; ?>>5</option>
			<option value="10" <?php if($vars['entity']->num_display == 10) echo "SELECTED"; ?>>10</option>
			<option value="15" <?php if($vars['entity']->num_display == 15) echo "SELECTED"; ?>>15</option>
			<option value="20" <?php if($vars['entity']->num_display == 20) echo "SELECTED"; ?>>20</option>
			<option value="30" <?php if($vars['entity']->num_display == 30) echo "SELECTED"; ?>>30</option>
			<option value="50" <?php if($vars['entity']->num_display == 50) echo "SELECTED"; ?>>50</option>
			<option value="100" <?php if($vars['entity']->num_display == 100) echo "SELECTED"; ?>>100</option>
		</select>
</p>
