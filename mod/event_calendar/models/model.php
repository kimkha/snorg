<?php
/**
 * Elgg event model
 * 
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 * 
 */

function event_calendar_get_event_for_edit($event_id) {
	if ($event_id && $event = get_entity($event_id)) {
		if ($event->canEdit()) {
			return $event;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function event_calendar_get_event_from_form() {
	
		// returns an event data object (not an ElggObject)
	
		$event_data = new stdClass();
		
		$event_data->event_id = get_input('event_id',0);	
		$event_data->access = get_input('access',ACCESS_PRIVATE);
		$event_data->title = get_input('title','');
		$event_data->description = get_input('brief_description','');
		$event_data->venue = get_input('venue','');
		$event_data->start_date = get_input('start_date','');
		$event_data->end_date = get_input('end_date','');
		$event_data->fees = get_input('fees','');
		$event_data->contact = get_input('contact','');
		$event_data->organiser = get_input('organiser','');
		$event_data->event_tags = get_input('event_tags','');
		$event_data->long_description = get_input('long_description','');
		
		return $event_data;
}

function event_calendar_set_event_from_form() {
	$result = new stdClass();
	$ed = event_calendar_get_event_from_form();
	$result->form_data = $ed;
	if ($ed->title && $ed->venue && $ed->start_date) {
		if ($ed->event_id) {
			$event = get_entity($ed->event_id);
			if (!$event) {
				// do nothing because this is a bad event id
				$result->success = false;
			}
		} else {
			$event = new ElggObject();
			$event->subtype = 'event_calendar';
			$event->owner_guid = $_SESSION['user']->getGUID();
			$group_guid = (int) get_input('group_guid',0);
			if ($group_guid) {
				$event->container_guid = $group_guid;	
			} else {
				$event->container_guid = $event->owner_guid;
			}
		}
		$event->access_id = $ed->access;
		$event->title = $ed->title;
		$event->description = $ed->description;
		$event->venue = $ed->venue;
		$event->start_date = strtotime($ed->start_date);
		if ($ed->end_date) {
			$event->end_date = strtotime($ed->end_date);
		} else {
			$event->end_date = $ed->end_date;
		}
		$event->fees = $ed->fees;
		$event->contact = $ed->contact;
		$event->organiser = $ed->organiser;
		$event->event_tags = array_reverse(string_to_tag_array($ed->event_tags));
		$event->long_description = $ed->long_description;
		$result->success = $event->save();
		$result->event = $event;
	} else {
		// required data missing
		$result->success = false;
	}
	
	return $result;
}

function event_calendar_get_events_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$container_guid=0) {
	if ($is_count) {
		$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", 0, $container_guid, $limit,$offset,"",0,false,true);
		return $count;
	} else {
		$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", 0, $container_guid, $limit,$offset,"",0,false,false);
		return event_calendar_vsort($events,'start_date');
	}
}

function event_calendar_get_events_for_user_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$user_guid,$container_guid=0) {
	if ($is_count) {
		$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", $user_guid, $container_guid, $limit,$offset,"",0,true,true);
		return $count;
	} else {
		$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
			$start_date, $end_date, "object", "event_calendar", $user_guid, $container_guid, $limit,$offset,"",0,true,false);
		return event_calendar_vsort($events,'start_date');
	}
}

function event_calendar_get_events_for_friends_between($start_date,$end_date,$is_count,$limit=10,$offset=0,$user_guid,$container_guid=0) {
	if ($user_guid) {
		$friends = get_user_friends($user_guid);
		if ($friends) {
			$friend_guids = array();
			foreach($friends as $friend) {
				$friend_guids[] = $friend->getGUID();
			}
			if ($is_count) {
				$count = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
					$start_date, $end_date, "object", "event_calendar", $friend_guids, $container_guid, $limit,$offset,"",0,true,true);
				return $count;
			} else {
				$events = event_calendar_get_entities_from_metadata_between('start_date','end_date', 
					$start_date, $end_date, "object", "event_calendar", $friend_guids, $container_guid, $limit,$offset,"",0,true,false);
				return event_calendar_vsort($events,'start_date');
			}
		}
	}
	return array();
}

function event_calendar_vsort($original,$field,$descending = false) {
    if (!$original) {
        return $original;
    }
    $sortArr = array();
   
    foreach ( $original as $key => $item ) {
        $sortArr[ $key ] = $item->$field;
    }

    if ( $descending ) {
        arsort( $sortArr );
    } else {
        asort( $sortArr );
    }
   
    $resultArr = array();
    foreach ( $sortArr as $key => $value ) {
        $resultArr[ $key ] = $original[ $key ];
    }

    return $resultArr;
}

	/**
	 * Return a list of entities based on the given search criteria.
	 * In this case, returns entities with the given metadata between two values inclusive
	 * 
	 * @param mixed $meta_start_name 
	 * @param mixed $meta_end_name 
	 * @param mixed $meta_start_value - start of metadata range, must be numerical value
	 * @param mixed $meta_end_value - end of metadata range, must be numerical value
	 * @param string $entity_type The type of entity to look for, eg 'site' or 'object'
	 * @param string $entity_subtype The subtype of the entity.
	 * @param mixed $owner_guid Either one integer user guid or an array of user guids
	 * @param int $container_guid If supplied, the result is restricted to events associated with a specific container
	 * @param int $limit 
	 * @param int $offset
	 * @param string $order_by Optional ordering.
	 * @param int $site_guid The site to get entities for. Leave as 0 (default) for the current site; -1 for all sites.
	 * @param boolean $filter Filter by events in personal calendar if true
	 * @param true|false $count If set to true, returns the total number of entities rather than a list. (Default: false)
	 * 
	 * @return int|array A list of entities, or a count if $count is set to true
	 */
	function event_calendar_get_entities_from_metadata_between($meta_start_name, $meta_end_name, $meta_start_value = "", $meta_end_value = "", $entity_type = "", $entity_subtype = "", $owner_guid = 0, $container_guid = 0, $limit = 10, $offset = 0, $order_by = "", $site_guid = 0, $filter = false, $count = false)
	{
		global $CONFIG;
		
		$meta_start_n = get_metastring_id($meta_start_name);
		$meta_end_n = get_metastring_id($meta_end_name);
			
		$entity_type = sanitise_string($entity_type);
		$entity_subtype = get_subtype_id($entity_type, $entity_subtype);
		$limit = (int)$limit;
		$offset = (int)$offset;
		if ($order_by == "") $order_by = "e.time_created desc";
		$order_by = sanitise_string($order_by);
		$site_guid = (int) $site_guid;
		if ((is_array($owner_guid) && (count($owner_guid)))) {
			foreach($owner_guid as $key => $guid) {
				$owner_guid[$key] = (int) $guid;
			}
		} else {
			$owner_guid = (int) $owner_guid;
		}
		
		if ((is_array($container_guid) && (count($container_guid)))) {
			foreach($container_guid as $key => $guid) {
				$container_guid[$key] = (int) $guid;
			}
		} else {
			$container_guid = (int) $container_guid;
		}
		if ($site_guid == 0)
			$site_guid = $CONFIG->site_guid;
			
		//$access = get_access_list();
			
		$where = array();
		
		if ($entity_type!="")
			$where[] = "e.type='$entity_type'";
		if ($entity_subtype)
			$where[] = "e.subtype=$entity_subtype";
		$where[] = "m.name_id='$meta_start_n'";
		$where[] = "m2.name_id='$meta_end_n'";
		$where[] = "((v.string >= $meta_start_value AND v.string <= $meta_end_value) OR ( v2.string >= $meta_start_value AND v2.string <= $meta_end_value) OR (v.string <= $meta_start_value AND v2.string >= $meta_start_value) OR ( v2.string <= $meta_end_value AND v2.string >= $meta_end_value))";
		if ($site_guid > 0)
			$where[] = "e.site_guid = {$site_guid}";
		if ($filter) {
			if (is_array($owner_guid)) {
				$where[] = "ms2.string in (".implode(",",$owner_guid).")";
			} else if ($owner_guid > 0) {
				$where[] = "ms2.string = {$owner_guid}";
			}
			
			$where[] = "ms.string = 'personal_event'";
		} else {
			if (is_array($owner_guid)) {
				$where[] = "e.owner_guid in (".implode(",",$owner_guid).")";
			} else if ($owner_guid > 0) {
				$where[] = "e.owner_guid = {$owner_guid}";
			}
		}
			
		if (is_array($container_guid)) {
			$where[] = "e.container_guid in (".implode(",",$container_guid).")";
		} else if ($container_guid > 0)
			$where[] = "e.container_guid = {$container_guid}";
		
		if (!$count) {
			$query = "SELECT distinct e.* "; 
		} else {
			$query = "SELECT count(distinct e.guid) as total ";
		}
			
		$query .= "from {$CONFIG->dbprefix}entities e JOIN {$CONFIG->dbprefix}metadata m on e.guid = m.entity_guid JOIN {$CONFIG->dbprefix}metadata m2 on e.guid = m2.entity_guid ";
		if ($filter) {
			$query .= "JOIN {$CONFIG->dbprefix}annotations a ON (a.entity_guid = e.guid) ";
			$query .= "JOIN {$CONFIG->dbprefix}metastrings ms ON (a.name_id = ms.id) ";
			$query .= "JOIN {$CONFIG->dbprefix}metastrings ms2 ON (a.value_id = ms2.id) ";
		}
		$query .= "JOIN {$CONFIG->dbprefix}metastrings v on v.id = m.value_id JOIN {$CONFIG->dbprefix}metastrings v2 on v2.id = m2.value_id where";
		foreach ($where as $w)
			$query .= " $w and ";
		$query .= get_access_sql_suffix("e"); // Add access controls
		$query .= ' and ' . get_access_sql_suffix("m"); // Add access controls
		$query .= ' and ' . get_access_sql_suffix("m2"); // Add access controls
		
		if (!$count) {
			$query .= " order by $order_by limit $offset, $limit"; // Add order and limit
			return get_data($query, "entity_row_to_elggstar");
		} else {
			if ($row = get_data_row($query))
				return $row->total;
		}
		return false;
	}
	
	function event_calendar_has_personal_event($event_id,$user_id) {
		$annotations = 	get_annotations($event_id, "object", "event_calendar", "personal_event", (int) $user_id, $user_id);
		if ($annotations && count($annotations) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function event_calendar_add_personal_event($event_id,$user_id) {
		create_annotation($event_id, "personal_event", (int) $user_id, 'integer', $user_id, ACCESS_PUBLIC);
	}
	
	function event_calendar_remove_personal_event($event_id,$user_id) {
		$annotations = 	get_annotations($event_id, "object", "event_calendar", "personal_event", (int) $user_id, $user_id);
		if ($annotations) {
			foreach ($annotations as $annotation) {
				$annotation->delete();
			}
		}
		
	}
	
	function event_calendar_get_personal_events_for_user($user_id,$limit) {
		$events = 	get_entities_from_annotations("object", "event_calendar", "personal_event", $user_id, $user_id, 0, 1000);
		$final_events = array();
		if ($events) {
			$now = time();
			$one_day = 60*60*24;
			// don't show events that have been over for more than a day
			foreach($events as $event) {
				if (($event->start_date > $now-$one_day) || ($event->end_date && ($event->end_date > $now-$one_day))) {
					$final_events[] = $event;
				}
			}
		}
		$sorted = event_calendar_vsort($final_events,'start_date');
		return array_slice($sorted,0,$limit);		
	}
	
	function event_calendar_get_users_for_event($event_id,$limit,$offset,$is_count) {
		if ($is_count) {
			return count_annotations($event_id, "object", "event_calendar", "personal_event");
		} else {
			$users = array();
			$annotations = get_annotations($event_id, "object", "event_calendar", "personal_event", "", 0, $limit, $offset);
			if ($annotations) {
				foreach($annotations as $annotation) {
					if (($user = get_entity($annotation->value)) && ($user instanceOf ElggUser)) {
						$users[] = $user;
					}
				}
			}
			return $users;
		}
	}

?>