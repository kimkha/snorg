<?php

	/**
	* Notebook
	* 
	* All the Notebook CSS can be found here
	* 
	* @package notebook
	* @author KimKha
	*/
	
	gatekeeper();
	
	$userId = get_loggedin_userid();
	
	$result = array();
	$result['title'] = nl2br(wordwrap(get_input('title'), 8, "<wbr />", true));
	$result['description'] = nl2br(wordwrap(get_input('description'), 8, "<wbr />", true));
	$result['category'] = nl2br(wordwrap(get_input('category'), 8, "<wbr />", true));
	$result['comment'] = nl2br(wordwrap(get_input('comment'), 8, "<wbr />", true));
	
		$notebook = new ElggObject();
		$notebook->subtype = NOTEBOOK_SUBTYPE;
		$notebook->access_id = ACCESS_LOGGED_IN;
		$notebook->owner_guid = $userId;
		$notebook->annotate(NOTEBOOK_TITLE, $result['title'], ACCESS_LOGGED_IN, $userId);
		$notebook->annotate(NOTEBOOK_DESCRIPTION, $result['description'], ACCESS_LOGGED_IN, $userId);
		$notebook->annotate(NOTEBOOK_CATEGORY, $result['category'], ACCESS_LOGGED_IN, $userId);
		$notebook->annotate(NOTEBOOK_COMMENT, $result['comment'], ACCESS_LOGGED_IN, $userId);
		$notebook->save();
		
		$notebook->addRelationship($userId, NOTEBOOK_RELATIONSHIP);
	
	header("Content-Type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo json_encode($result);
	
	
?>
