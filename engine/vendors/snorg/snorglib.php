<?php

	define("_WALLPOST_LIKE_", "wallpost_like");
	define("_WALLPOST_UNLIKE_", "wallpost_unlike");

	/**
	 * Get content from URL
	 * 
	 * @author "KimKha 
	 * @package snorg
	 */
	function cfopen($url, $limit = 8192)
	{
		$matches = parse_url($url);
		$host = $matches['host'];
		$script = (isset($matches['path'])?$matches['path']:'/').(isset($matches['query'])?'?'.$matches['query']:'').(isset($matches['fragment'])?'#'.$matches['fragment']:'');
		$port = !empty($matches['port']) ? $matches['port'] : 80;
	
		$out = "GET $script HTTP/1.1\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: en-us\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n\r\n";
	
		$fp = fsockopen($host, $port, $errno, $errstr, 30);
	
		$return = '';
		if($fp)
		{
			stream_set_blocking($fp, TRUE);
			stream_set_timeout($fp, 30);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if ( !$status['timed_out'] )
			{
				while(!feof($fp)) {
					$return .= @fread($fp, $limit);
				}
			}
		}
		@fclose($fp);
		return $return;
	}
	
	/**
	 * Register one object to wallpost
	 * 
	 * @author "KimKha 
	 * @param string $object The object name
	 * @param string $view_func The callback function
	 * @return true|false
	 * @package snorg
	 */
	function register_wallpost($object, $view_func) {
		if (!is_registered_entity_type("object", $object)) { // Not exist this subtype
			register_entity_type("object", $object);
		}
		
		return (is_register_wallpost($object) || add_to_register("wallpost_type", $object, $view_func));
	}
	
	/**
	 * Get list of wallpost object
	 * 
	 * @author "KimKha 
	 * @param int|array $owner_guid GUID of user(s), or 0 to get all object name
	 * @return array|false Array of object name
	 * @package snorg
	 */
	function get_register_wallpost($owner_guid = 0) {
		$all = get_register("wallpost_type");
		if (!$all) return false;
		
		// Multi-user
		if (is_array($owner_guid) && count($owner_guid) >0) {
			$return = array();
			foreach ($owner_guid as $own) {
				$own = (int) $own;
				$result = get_register_wallpost($own);
				$return = array_merge($return, $result);
			}
			return $return;
		}
		
		if ($owner_guid > 0) {
			foreach ($all as $key => $value) {
				$name = "Wallpost_".$key;
				$setting = get_plugin_usersetting($name, $owner_guid, "profile");
				
				if ($setting == 'disable') {
					unset($all[$key]);
				}
			}
		}
		
		return array_keys($all);
	}
	
	/**
	 * Get array of all wallpost object.
	 * 
	 * @author "KimKha 
	 * @param int $user_guid The GUID of the owning user
	 * @param string $subtype Optionally, the subtype of objects
	 * @param int $limit The number of results to return (default 10)
	 * @param int $offset Indexing offset, if any
	 * @param int $timelower The earliest time the entity can have been created. Default: all
	 * @param int $timeupper The latest time the entity can have been created. Default: all
	 * @return false|array An array of ElggObjects or false, depending on success
	 * @package snorg
	 */
	function get_user_wallpost_objects($user_guid, $subtype = "", $limit = 10, $offset = 0, $timelower = 0, $timeupper = 0) {
		if (is_array($subtype)) {
			if (!isset($subtype['object'])) $subtype['object'] = array();
			$subtype['object'][] = 'wallpost';
		}
		else if ($subtype == "") {
			$subtype = "wallpost";
		}
		else {
			$new = $subtype;
			$subtype = array();
			$subtype['object'] = array($new, "wallpost");
		}
		return get_user_objects($user_guid, $subtype, $limit, $offset, $timelower, $timeupper);
	}
	
	/**
	 * Whether object is wallpost
	 * 
	 * @author "KimKha 
	 * @param string $object The object name
	 * @return true|false
	 * @package snorg
	 */
	function is_register_wallpost($object) {
		$all = get_register("wallpost_type");
		if (!isset($all[$object]) || empty($all[$object])) {
			return false;
		}
		return true;
	}
	
	/**
	 * View wallpost 
	 * The callback function of object will run. Exp: hook_func($vars); 
	 * 
	 * @author "KimKha 
	 * @param string $object The object name to view 
	 * @param array $vars The array of parameter for callback function: 
	 * 				use $vars['entity'] to get current entity 
	 * @return HTML
	 * @package snorg
	 */
	function view_wallpost($object, $vars) {
		$all = get_register("wallpost_type");
		$view_func = $all[$object]->value;
		
		if (!empty($view_func) && function_exists($view_func)) {
			return $view_func($vars);
		}
		else {
			return view_onwall_wallpost($vars);
		}
	}
	
	/**
	 * Send message to wallpost
	 * 
	 * @author "KimKha 
	 * @param int $owner_guid
	 * @param string $title 
	 * @param string $content It is null if $type='short'
	 * @param string $type Value is 'short' or 'full'
	 * @param int $access_id 
	 * @return int|false GUID of new ElggObject of this message or failure
	 * @package snorg
	 */
	function wallpost($owner_guid=0, $title="", $content="", $type="full", $access_id=ACCESS_PUBLIC) {
		if ($owner_guid <= 0) return false;
		
		
		switch ($type) {
			case "short":
				if ($title=="") return false;
				$content = '';
				$subtype = "short_wallpost";
				break;
			case "full":
			default:
				if ($title=="" && $content=="") return false;
				$subtype = "wallpost";
				break;
		}
		
		if (!is_registered_entity_type("object", $subtype)) {
			register_wallpost($subtype, "view_onwall_".$subtype);
		}
		
		$obj = new ElggObject();
		$obj->subtype = $subtype;
		$obj->owner_guid = $owner_guid;
		$obj->container_guid = $owner_guid;
		$obj->access_id = $access_id;
		$obj->title = $title;
		$obj->description = $content;
		
		return $obj->save();
	}
	
	
	/**
	 * View full wallpost, sent by message to wallpost() function
	 * 
	 * @author "KimKha 
	 * @param array $vars = array('entity'=>$entity, 'viewtype'=>'wall') 
	 * @return string|false HTML to view
	 * @package snorg
	 */
	function view_onwall_wallpost($vars) {
		global $CONFIG;
		if ($vars['viewtype']!='wall' || !elgg_view_exists("object/wall")){
			return false;
		}
		
		$entity = $vars['entity'];
		$viewtype = $vars['viewtype'];
		
		$title = $entity->title;
		$content = "<p>". split_html($entity->description) ."</p>";
		$status = ' ';
		$dellink = '';
		
		return elgg_view("object/wall", array(
					'entity'	=> $entity,
					'viewtype'	=> $viewtype,
					'title'		=> $title,
					'content'	=> $content,
					'status'	=> $status,
					'dellink'	=> $dellink
		));
	}
	
	/**
	 * View short wallpost, sent by message to wallpost() function
	 * 
	 * @author "KimKha 
	 * @param array $vars = array('entity'=>$entity, 'viewtype'=>'wall') 
	 * @return string|false HTML to view
	 * @package snorg
	 */
	function view_onwall_short_wallpost($vars) {
		global $CONFIG;
		if ($vars['viewtype']!='wall' || !elgg_view_exists("object/wall")){
			return false;
		}
		
		$entity = $vars['entity'];
		$viewtype = $vars['viewtype'];
		$user = $entity->getOwnerEntity();
		
		$title = $entity->title;
		$img = elgg_view('profile/icon', array('entity' => $user, 'size' => 'topbar', 'align' => 'left'));
		
		$content = "<div class='short-wall-singlepage' id='wall-singlepage-{$entity->guid}'><div class='short-wall-post'>".$img.$title."</div></div>";
		
		return $content;
	}
	
	/**
	 * Get object name with subtype structure (define of Elgg)
	 * 
	 * @author "KimKha 
	 * @param int $owner_guid User guid of owner, or 0 to get all object name 
	 * @return array|false Array of subtype structure
	 * @package snorg
	 */
	function get_wallpost_object($owner_guid = 0) {
		$object = get_register_wallpost($owner_guid);
		if (!$object) $object = array("srghsreyhjhl");
		return array('object' => $object);
	}
	
	/**
	 * View comment on wallpost
	 * 
	 * @author "KimKha 
	 * @param ElggAnnotation $comment 
	 * @return string HTML to view 
	 * @package snorg
	 */
	function elgg_view_comment(ElggAnnotation $comment, $bypass = true, $debug = false) {
		$comment->view = "annotation/onwall";
		return elgg_view_annotation($comment, $bypass, $debug);
	}
	
	/**
	 * Wrap string if it have long word
	 * 
	 * @author "KimKha 
	 * @param $content Original string
	 * @return string
	 * @package snorg
	 */
	function string_wrap($content) {
    	$cont = explode(' ', $content);
    	$return = array();
    	foreach ($cont as $i => $val) {
    		$return[] = wordwrap($val, 8, "<wbr />", true);
    	}
    	return implode(" ", $return);
	}
	
	/**
	 * Split long name and insert '..' if yes
	 * 
	 * @author "KimKha 
	 * @param $name Name to split
	 * @param $num Max numbers of name
	 * @return Splitted name
	 * @package snorg
	 */
	function splitname($name, $num=15) {
		if (strlen($name) > $num) return substr($name, 0, $num-1)."..";
		return $name;
	}
	
	/**
	 * Remove all HTML tags and split first paragraph of string
	 * 
	 * @author KimKha
	 * @param string $string HTML string
	 * @param int $num Number of characters to split (0 = unlimited)
	 * @return string Spitted first paragraph
	 * @package snorg
	 */
	function split_html($string, $num=0) {
		$ptags = array(
			'th', 'td', 'div', 'pre', 'p', 'blockquote'
		);
		foreach ($ptags as $p) {
			$pos = strpos($string, '</' . $p . '>');
			if ($pos !== FALSE) {
				$string = substr($string, 0, $pos);
				$pos = strrpos($string, '<' . $p);
				$string = substr($string, $pos);
			}
		}
		$brtags = array (
			'br', 'br /'
		);
		foreach ($brtags as $b) {
			$pos = strpos($string, '<' . $b . '>');
			if ($pos !== FALSE) {
				$string = substr($string, 0, $pos);
			}
		}
		
		$alltags = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|br|img|object|param|embed|script|style)';
		$string = preg_replace('!(<' . $alltags . '[^>]*>)!', "", $string);
		$string = preg_replace('!(</' . $alltags . '>)!', "", $string);
		
		$string = parse_urls($string);
		
		if ($num <= 0) {
			return $string;
		}
		return splitname($string, $num);
	}
	
	/**
	 * @author KimKha
	 * @param string $string HTML string
	 * @param int $p Number of paragraphs
	 */
	function split_paragraph($string, $num=1) {
		$ptags = array(
			'p', 'div', 'pre', 'blockquote'
		);
		$count = 0;
		$finish = false;
		foreach ($ptags as $p) {
			$pos = strpos($string, '</' . $p . '>');
			if ($pos !== FALSE) {
				$count++;
				if ($count >= $num) {
					$string = substr($string, 0, $pos);
					$pos = strrpos($string, '<' . $p);
					$string = substr($string, $pos);
					break;
				}
			}
		}
		return $string;
	}
	
	/**
	 * Change subtype of Object to another one
	 * 
	 * @author KimKha
	 * @param ElggEntity $object Current object
	 * @param string $subtype New subtype name
	 * @return true|false Depend on success
	 * @package snorg
	 */
	function change_subtype(ElggEntity $object, $subtype) {
		global $CONFIG;
		
		$type = $object->getType();
		$id = get_subtype_id($type, $subtype);
		
		if ($id == 0) {
			return false;
		}
		
		$object->subtype = $subtype;
		if (!$object->save()) {
			return false;
		}
		return true;
	}
	
	/**
	 * Get list of entities with subtype from given entities list
	 * 
	 * @author "KimKha 
	 * @param array $entities Array of given entities
	 * @param string $subtype Subtype you need to get
	 * @return array|false 
	 * @package snorg
	 */
	function parse_entities_by_subtype($entities, $subtype) {
		if (!is_array($entities)) {
			return false;
		}
		
		$return = array();
		
		foreach ($entities as $entity) {
			if ($entity->getSubtype() == $subtype) {
				$return[] = $entity;
			}
		}
		
		return $return;
	}
	
	/**
	 * Check whether multi relationship is exist.
	 * Each relationship string is $relationship.$subrelationship[index]
	 * 
	 * @param int $guid_one 
	 * @param string $relationship 
	 * @param int $guid_two 
	 * @param array $subrelationship
	 * @return true|false  
	 * @package snorg
	 */
	function check_entity_multi_relationship($guid_one, $relationship, $guid_two, $subrelationship=array()) {
		if (empty($subrelationship)) return check_entity_relationship($guid_one, $relationship, $guid_two);
		
		foreach ($subrelationship as $s) {
			if ($obj = check_entity_relationship($guid_one, $relationship.$s, $guid_two)) {
				return $obj;
			}
		}
		return false;
	}
	
	/**
	 * Trim string and replace whitespace to make smart name (for array)
	 * 
	 * @author "KimKha 
	 * @param array $array Array of strings to convert 
	 * @return array Result array
	 * @package snorg
	 */
	function convert_whitespace_array($array) {
		if (empty($array)) return false;
		
		$return = array();
		foreach ($array as $value) {
			$return[] = convert_whitespace($value);
		}
		return $return;
	}
	
	/**
	 * Trim string and replace whitespace to make smart name
	 * 
	 * @author "KimKha 
	 * @param string $current String to convert
	 * @return string Result string
	 * @package snorg
	 */
	function convert_whitespace($current) {
		$current = trim($current);
		$current = strtolower($current);
		$current = str_replace(" ", "___", $current);
		return $current;
	}
	
	/**
	 * Unique given array of entities by an attribute
	 * 
	 * @author "KimKha 
	 * @param array $list Array of entities
	 * @param string $attr Name of attribute
	 * @param array $given Given array that list are inserted into
	 * @return array Result
	 * @package snorg
	 */
	function array_unique_by_attribute($list, $attr, $given = array()) {
		$new = $given;
		$exist = array();
		
		foreach ($list as $object) {
			if (!in_array($object->$attr, $exist)) {
				$new[] = $object;
				$exist[] = $object->$attr;
			}
		}
		
		return $new;
	}
	
	/**
	 * Check whether a file is included
	 * 
	 * @author "KimKha 
	 * @param string $filename You can use pages/edit.php
	 * @return true|false
	 * @package snorg
	 */
	function is_included($filename) {
		$filename = str_replace("\\", "/", $filename);
		$filename = trim($filename);
		
		$all = get_included_files();
		
		foreach ($all as $included) {
			$included = str_replace("\\", "/", $included);
			$included = trim($included);
			if ($filename == $included) return true;
		}
		
		return false;
	}
	
	/**
	 * Automatically views taguser
	 *
	 * @author bkit06
	 * @package snorg
	 */
	function elgg_view_taguer($entity){
		if (!($entity instanceof ElggEntity)) return false;
	    		  
		$taggeduser .= elgg_view('taguser/tagblock',array('entity' => $entity->getGUID()));
	        
	    return $taggeduser;
	}
	
	/**
	 * 
	 * @author Huyvtq
	 * @package snorg
	 */
	function get_entities_order_by_metadata($type = "", $subtype = "", $owner_guid = 0, $order_by = "", $limit = 10, $offset = 0, $count = false, $site_guid = 0, $container_guid = null, $timelower = 0, $timeupper = 0)
	{
		global $CONFIG;
		
		if ($subtype === false || $subtype === null || $subtype === 0)
			return false;
		/////////////////////////////////////	
		$e = 'e.';
		$md = 'md.';
		$ms1 = 'ms1.';
		$ms2 = 'ms2.';
		
		$from = "{$CONFIG->dbprefix}entities as e ";
		$from .= "left join ( {$CONFIG->dbprefix}metadata as md ";
		$from .= "join {$CONFIG->dbprefix}metastrings as ms1 ";
		$from .= "join {$CONFIG->dbprefix}metastrings as ms2) ";
		
		$on =  "( {$md}entity_guid = {$e}guid )";
		$on.= "AND ({$md}name_id = {$ms1}id)";
		$on.= "AND ({$md}value_id = {$ms2}id)";
		$on.= "AND ({$ms1}string = '{$order_by}')";

		
		//////////////////////////////////////
		if ($order_by == "") $order_by = "time_created desc";
		$order_by = sanitise_string($order_by);
		$limit = (int)$limit;
		$offset = (int)$offset;
		$site_guid = (int) $site_guid;
		$timelower = (int) $timelower;
		$timeupper = (int) $timeupper;
		if ($site_guid == 0)
			$site_guid = $CONFIG->site_guid;
				
		$where = array();
		//////////////////////////////////
		
		
		if (is_array($subtype)) {			
			$tempwhere = "";
			if (sizeof($subtype))
			foreach($subtype as $typekey => $subtypearray) {
				foreach($subtypearray as $subtypeval) {
					$typekey = sanitise_string($typekey);
					if (!empty($subtypeval)) {
						$subtypeval = (int) get_subtype_id($typekey, $subtypeval);
					} else {
						$subtypeval = 0;
					}
					if (!empty($tempwhere)) $tempwhere .= " or ";
					$tempwhere .= "({$e}type = '{$typekey}' and {$e}subtype = {$subtypeval})";
					
				}								
			}
			if (!empty($tempwhere)) $where[] = "({$tempwhere})";
			
		} else {
		
			$type = sanitise_string($type);
			if ($subtype !== "")
				$subtype = get_subtype_id($type, $subtype);
			
			if ($type != "")
				$where[] = "{$e}type='$type'";
			if ($subtype!=="")
				$where[] = "{$e}subtype=$subtype";
				
		}
			
		if ($owner_guid != "") {
			if (!is_array($owner_guid)) {
				$owner_array = array($owner_guid);
				$owner_guid = (int) $owner_guid;
			//	$where[] = "{$e}owner_guid = '$owner_guid'";
			} else if (sizeof($owner_guid) > 0) {
				$owner_array = array_map('sanitise_int', $owner_guid);
				// Cast every element to the owner_guid array to int
			//	$owner_guid = array_map("sanitise_int", $owner_guid);
			//	$owner_guid = implode(",",$owner_guid);
			//	$where[] = "owner_guid in ({$owner_guid})";
			}
			if (is_null($container_guid)) {
				$container_guid = $owner_array;
			}
		}
		if ($site_guid > 0)
			$where[] = "{$e}site_guid = {$site_guid}";

		if (!is_null($container_guid)) {
			if (is_array($container_guid)) {
				foreach($container_guid as $key => $val) $container_guid[$key] = (int) $val;
				$where[] = "{$e}container_guid in (" . implode(",",$container_guid) . ")";
			} else {
				$container_guid = (int) $container_guid;
				$where[] = "{$e}container_guid = {$container_guid}";
			}
		}
		
		if ($timelower)
			$where[] = "{$e}time_created >= {$timelower}";
		if ($timeupper)
			$where[] = "{$e}time_created <= {$timeupper}";
			
		if (!$count) {
			$query = "SELECT e.* from {$from} on {$on} where ";
		} else {
			$query = "SELECT count(guid) as total from {$from} on {$on}  where ";
		}
		
		foreach ($where as $w)
			$query .= " $w and ";
		$query .= "( (1 = 1) and e.enabled='yes')";
		
		if (!$count) {
			$query .= " order by CAST({$ms2}string as DECIMAL) desc";
			if ($limit) $query .= " limit $offset, $limit"; // Add order and limit
			
			$dt = get_data($query, "entity_row_to_elggstar");
			return $dt;
		} else {
			$total = get_data_row($query);
			return $total->total;
		}
	}

	
	/**
	 * Init something for KK lib
	 * 
	 * @author "KimKha 
	 * @package snorg
	 */
	function kk_init() {
		register_wallpost("wallpost", "view_onwall_wallpost");
		register_wallpost("short_wallpost", "view_onwall_short_wallpost");
		// snorg - bkit06
		register_action("taguser/tag");
		register_action("taguser/untag");
		
	}
	
	// register something for kk lib
	register_elgg_event_handler('init','system','kk_init');
	
	
?>