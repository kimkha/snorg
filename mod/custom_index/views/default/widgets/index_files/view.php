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
	
	$limit = (int)$vars['entity']->num_display;
	if (!$limit) $limit = 10;
	$files = list_entities('object','file',0,$limit,false, false, false);

    if (!empty($files)) {
        echo $files;//this will display files
    }else{
        echo "<p><?php echo elgg_echo('custom:nofiles'); ?></p>";
    }
	
?>