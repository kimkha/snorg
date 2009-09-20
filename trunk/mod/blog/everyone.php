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
		
		$order_type = get_input("orderby","");
		$selected_time = "";
		$selected_total = "";
		$selected_average = "";
		
		if ($order_type == "ratetotal"){
			$selected_total = "selected=\"selected\"";
		} else if ($order_type == "rateaverage"){
			$select_average = "selected=\"selected\"";
		} else {
			$selected_time = "selected=\"selected\"";
		}
		
		$order = "<div> Order by </div>";
		$order .= "<form id=\"frm_orderby\" action=\"{$CONFIG->wwwroot}mod/blog/everyone.php\" method=\"GET\" onchange=\"this.submit()\" >";
		$order .= "<select name=\"orderby\">";
		$order .= "<option value=\"\" {$selected_time}> Created time </option>";
		$order .= "<option value=\"ratetotal\" {$selected_total}> Rate point </option>";
		$order .= "<option value=\"rateaverage\" {$select_average}> Average rate point </option>";
		$order .= "</select>";
		$order .= "</form>";
		
		
		
		
		$area2 = elgg_view_title(elgg_echo('blog:everyone'));
		$area2 .= $order;

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