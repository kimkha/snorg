<?php

	define("_WALLPOST_LIKE_", "wallpost_like");
	define("_WALLPOST_UNLIKE_", "wallpost_unlike");

	/**
	 * Get content from URL
	 * 
	 * @author "KimKha 
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
	 * Change subtype of Object to another one
	 * 
	 * @author KimKha
	 * @param ElggEntity $object Current object
	 * @param string $subtype New subtype name
	 * @return true|false Depend on success
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
	 * Init something for KK lib
	 * 
	 * @author "KimKha 
	 */
	function kk_init() {
		register_wallpost("wallpost", "view_onwall_wallpost");
		register_wallpost("short_wallpost", "view_onwall_short_wallpost");
	}
	
	// register something for kk lib
	register_elgg_event_handler('init','system','kk_init');
	
?>