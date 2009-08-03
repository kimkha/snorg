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

	global $CONFIG;
	$page_owner = page_owner_entity();
	$you = $page_owner->guid;
	$me = $_SESSION['user']->getGUID();
	
	$query = "SELECT * from {$CONFIG->dbprefix}entity_relationships where guid_one=$you";
	$data = get_data($query);
?>

	<p>
		<? 
		
		foreach ($data as $idx => $rel) 
		{
			if (check_entity_relationship($me, 'friend', $rel->guid_two))
			{
				$mutural = get_user($rel->guid_two);
				echo $mutural->name.'<br />';
			}
		}
		
		?>
	</p>