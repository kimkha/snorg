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


	function people_you_might_know_get_entities($user_guid, $order_by = "", $limit = 10, $offset = 0, $count = false, $site_guid = 0)
	{
		global $CONFIG;
		
		$user_guid = (int)$user_guid;
		
		$friends = get_entities_from_relationship('friend',$user_guid,false,'user','',0,$limit);
		
		$friends_aux = array();
		if(is_array($friends))
			foreach($friends as $friend)
				$friends_aux[] = $friend->getGUID();

		$list_friends = 0;		
		if(!empty($friends_aux))
			$list_friends = implode(',',$friends_aux);
			
		if ($order_by == "") $order_by = "coincidences DESC";
		$order_by = sanitise_string($order_by);
		$limit = (int)$limit;
		$offset = (int)$offset;
		$site_guid = (int) $site_guid;
		if ($site_guid == 0)
			$site_guid = $CONFIG->site_guid;	
			
		if($count)
			$limit = "";
		else
			$limit = "LIMIT $offset, $limit";
			 
			
		$query = "SELECT e.*, count(guid_two) AS coincidences 
							FROM {$CONFIG->dbprefix}entity_relationships er, {$CONFIG->dbprefix}entities e  
							WHERE er.guid_one IN ($list_friends) 
							AND er.relationship = 'friend' 
							AND er.guid_two!=$user_guid 
							AND guid_two NOT IN ($list_friends)
							AND er.guid_two = e.guid
							GROUP BY guid_two HAVING coincidences>1";
		
		$query .= " ORDER BY $order_by $limit"; // Add limit and order
		$data = get_data($query, "entity_row_to_elggstar");
		if ($data)
			if (!$count) 
				return $data;
			else
			  // return count of friends if count == true  - Hoai
				return sizeof($data);
		
			
	return false;
	}
	
	function people_you_might_know_get_entities_list_entities($user_guid,$limit = 10, $fullview = true, $viewtypetoggle = false, $navigation = true)
	{
		
		$offset = (int) get_input('offset');
		$count = people_you_might_know_get_entities($user_guid,"",$limit,0,true);
		$entities = people_you_might_know_get_entities($user_guid,"",$limit,$offset);
		
		return elgg_view_entity_list($entities, $count, $offset, $limit, $fullview, $viewtypetoggle, $navigation);
	
	}

?>