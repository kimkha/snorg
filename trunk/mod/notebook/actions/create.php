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

$result = array();
$result['title'] = get_input('title');
$result['description'] = get_input('description');
$result['category'] = get_input('category', '');
$result['comment'] = get_input('comment', '');


header("Content-Type: application/json; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo json_encode($result);


?>
