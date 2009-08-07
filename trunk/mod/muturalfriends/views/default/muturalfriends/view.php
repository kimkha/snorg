<?php

	/**
	 * Elgg hoverover extender for blog
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	$page_owner = page_owner_entity();
	$you = $page_owner->guid;
	$me = $_SESSION['user']->getGUID();
	
	$list = get_user_friends($you);
	shuffle($list);
	
	$mutural = array();
	foreach ($list as $friend) 
	{
		if ($friend->isFriendOf($me)) // This is a mutural friend 
		{
			$mutural[] = $friend;
		}			
	}
?>

	<p>
		<? 
		$offset = get_input('offset', 0);
		$count = count($mutural);
		echo elgg_view_entity_list($mutural, $count, $offset, $count);
		
		?>
	</p>