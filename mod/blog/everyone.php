<?php

	/**
	 * Elgg view all blog posts from all users page
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	// Load Elgg engine
		define('everyoneblog','true');
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
// Get the current page's owner
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
		set_context('blog');
		
		$order_type = get_input("orderby","");
		
		$select_options = array(
			'time' => 'Created time',
			'ratetotal' => 'Rate point',
			'rateaverage' => 'Average rate point',
		);
		
		$select = "Order by: ".elgg_view("input/pulldown", array(
			'internalname' => 'orderby',
			'options_values' => $select_options,
			'value' => $order_type,
			'js' => 'onchange="$(this).parent(\'form\').submit()"',
		));
		
		$order = "<div id='order-blog'>" . elgg_view("input/form", array(
			'internalid' => 'frm_orderby',
			'action' => '?',
			'method' => 'GET',
			'disable_security' => true,
			'body' => $select,
		)) . "</div>";
		
		
		$area2 = $order;
		$area2 .= elgg_view_title(elgg_echo('blog:everyone'));

		if ((!$order_type) || ($order_type=="")){
			$area2 .= list_entities('object','blog',0,10,false);
		} else {
			
			$area2 .= list_entities_order_by_metadata('object','blog',$order_type,0,10,false);	
		}

		// get tagcloud
		// $area3 = "This will be a tagcloud for all blog posts";

		// Get categories, if they're installed
		global $CONFIG;
		$area3 = elgg_view('blog/categorylist',array('baseurl' => $CONFIG->wwwroot . 'search/?subtype=blog&tagtype=universal_categories&tag=','subtype' => 'blog'));

		$body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);
		
	// Display page
		page_draw(elgg_echo('blog:everyone'),$body);
		
?>