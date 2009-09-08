<?php
	/**
	 * People you might know Widget
	 * 
	 * @package people_you_might_know
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author bkit06
	 * @copyright 2009
	 * @link http://www.bkitclub.net/
 */

	$num = (int) $vars['entity']->num_display;
    if (!$num)
		$num = 5;

	$page_owner = get_loggedin_user();
	set_page_owner(get_loggedin_userid());
	
	// get list people who you might know
 	$list = people_you_might_know_get_entities($page_owner->getGUID());

	// show user icon to widget
	
	if ( count($list) > 0)
	{
		$i = 0;
		echo " <a id='btn_pymk_show_all' href='javascript:void(0);'> " . ' ' . elgg_echo('friends:widget:showall')."</a>";
		echo "<div id=\"widget_friends_list\">";
		foreach ( $list as $people)
		{
			$i++;
			if($i > $num)
				break;
			
				echo "<div class=\"widget_friends_singlefriend\" >";
				echo elgg_view("profile/icon",array('entity' => $people, 'size' => "small"));
				echo "</div>";
		
			
		}
	echo "</div>";
	}
	
	

  
 
?>