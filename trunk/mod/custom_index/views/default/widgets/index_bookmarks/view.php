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
	if (!$limit) $limit = 4;
	$bookmarks = list_entities('object','bookmarks',0,$limit,false, false, false);
	
    if (isset($bookmarks)) 
        echo $bookmarks; //display bookmarks
	
?>