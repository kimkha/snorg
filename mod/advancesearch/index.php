<?php
	/**
	 * Advance search
	 * Search users through them information
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
	
	gatekeeper();

	set_context('advancesearch');
	
	$area1 = elgg_view_title(elgg_echo('advancesearch'));
	$area2 = elgg_view('advancesearch/view');
	
	// Format page
	$body = elgg_view_layout('one_column', $area1.$area2);

	echo page_draw(elgg_echo('advancesearch'),$body);
	
?>