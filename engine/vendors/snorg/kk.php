<?php

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
		return add_to_register("wallpost_type", $object, $view_func);
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
	
	function create_wallpost_object($owner_guid, $viewtype = 'wall', $title, $content, $status, $dellink) {
		
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
			return elgg_view("object/wall", $vars);
		}
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
		if (!$object) $object = array("srghshl");
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

?>