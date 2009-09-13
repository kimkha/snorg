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
	$newest_members = get_entities_from_metadata('icontime', '', 'user', '', 0, $limit);
	$newest_members = get_entities('user','',0,'',$limit);
	
    foreach($newest_members as $members){
        echo "<div class=\"index_member_item\">";
        echo elgg_view("profile/icon",array('entity' => $members, 'size' => 'small'));
        echo "</div>";
    }
	
?>