<?php

	/**
	 * People you might know.
	 * 
	 * @package people_you_might_know
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Pedro Prez
	 * @copyright 2009
	 * @link http://www.pedroprez.com.ar/
 */

	$page_owner = page_owner_entity();	
	
	if($page_owner->getGUID()==get_loggedin_userid())
	{
		$count = people_you_might_know_get_entities($page_owner->getGUID(),"",$limit,0,true);
		if((int)$count > 0)
		{ 
			$body .= "<div id='peopleyoumightknow-cont'>";
			$body .= "<h4>" . elgg_echo("peopleyoumightknow") . "</h4>";
			$body .= people_you_might_know_get_entities_list_entities($vars['user']->getGUID(),3);
			$body .= "<a href='{$vars['url']}/pg/peopleyoumightknow/' >" . elgg_echo("peopleyoumightknow:seeall") . "</a>";
			$body .= "</div>";
			echo $body;
		}
	}
?>

