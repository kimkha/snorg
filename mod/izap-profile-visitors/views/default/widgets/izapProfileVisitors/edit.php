<?php
	/**
	 * iZAP izap profile visitor
	 * 
	 * @license GNU Public License version 3
	 * @author iZAP Team "<support@izap.in>"
	 * @link http://www.izap.in/
	 * @version 1.1
	 * @compatibility elgg-1.5
	 */

?>
<p>
		<?php echo elgg_echo('izapProfileVisitor:NumberOfVisitors'); ?>:
		<select name="params[num_display]">
		    <option value="5" <?php if($vars['entity']->num_display == 5) echo "SELECTED"; ?>>5</option>
		    <option value="10" <?php if($vars['entity']->num_display == 10) echo "SELECTED"; ?>>10</option>
		    <option value="15" <?php if($vars['entity']->num_display == 15) echo "SELECTED"; ?>>15</option>
		    <option value="20" <?php if($vars['entity']->num_display == 20) echo "SELECTED"; ?>>20</option>
		</select>
	</p>