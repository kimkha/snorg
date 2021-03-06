<?php

/**
	 * Elgg invite page
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @link http://elgg.org/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
	
	gatekeeper();
	
	set_context('sitenotification');
	
	$area1 = elgg_view_title(elgg_echo('sitenotification:title'));
	$area2 = elgg_view('sitenotification/view');
	
	// Format page
	$body = elgg_view_layout('one_column', $area1.$area2);
	
	mark_all_as_read(get_loggedin_userid());

	page_draw(elgg_echo('sitenotification:title'),$body);
	
?>