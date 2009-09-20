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
		
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set blog title
		if($page_owner == $_SESSION['user']){
			$area2 = elgg_view_title(elgg_echo('blog:your'));
		}else{
			//$area1 = elgg_view_title($page_owner->username . "'s " . elgg_echo('blog'));
		}
		
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
		$order .= "<form id=\"frm_orderby\" action=\"{$CONFIG->wwwroot}pg/blog/Huyvtq\" method=\"GET\" onchange=\"this.submit()\" >";
		$order .= "<select name=\"orderby\">";
		$order .= "<option value=\"\" {$selected_time}> Created time </option>";
		$order .= "<option value=\"ratetotal\" {$selected_total}> Rate point </option>";
		$order .= "<option value=\"rateaverage\" {$select_average}> Average rate point </option>";
		$order .= "</select>";
		$order .= "</form>";
		
		$area2 .= $order;
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