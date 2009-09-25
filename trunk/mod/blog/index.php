<?php

	/**
	 * Elgg blog index page
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		
		global $CONFIG;
		set_context('blog');
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	// Get order by
		$order_type = get_input("orderby","");
		
		$select_options = array(
			'time' => 'Created time',
			'ratecount' => 'Total rates',
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

	//set blog title
		if($page_owner == $_SESSION['user']){
			$area2 .= elgg_view_title(elgg_echo('blog:your'));
		}else{
			$area2 .= elgg_view_title(sprintf(elgg_echo('blog:user'), $page_owner->username));
		}
		
		
	// Get a list of blog posts
		if ((!$order_type) || ($order_type=="")){
			
			$area2 .= list_user_objects($page_owner->getGUID(),'blog',10,false);
		} else {	
			
			$area2 .= list_entities_order_by_metadata('object','blog',$order_type,$page_owner->getGUID(),10,false);	
		}
	// Get blog tags

		// Get categories, if they're installed
		
		$area3 = elgg_view('blog/categorylist',array('baseurl' => $CONFIG->wwwroot . 'search/?subtype=blog&owner_guid='.$page_owner->guid.'&tagtype=universal_categories&tag=','subtype' => 'blog', 'owner_guid' => $page_owner->guid));
		
	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2, $area3);
		
	// Display page
		page_draw(sprintf(elgg_echo('blog:user'),$page_owner->name),$body);
		
?>