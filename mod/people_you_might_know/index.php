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

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  gatekeeper();
	
	set_context('peopleyoumightknow');
	
	$page_owner = get_loggedin_user();
	set_page_owner(get_loggedin_userid());
	
	$title = elgg_view_title(elgg_echo('peopleyoumightknow'));
  
  $body = people_you_might_know_get_entities_list_entities($page_owner->getGUID(),10);
  
  page_draw(elgg_echo('peopleyoumightknow'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
?>