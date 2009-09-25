<?php

	/**
	* Notebook
	* 
	* All the Notebook CSS can be found here
	* 
	* @package SNORG
	* @author KimKha
	*/
	
	gatekeeper();
	
	$user = get_loggedin_user();
	
	$notes = $user->getEntitiesFromRelationship(NOTEBOOK_RELATIONSHIP, true);
	krsort($notes);
	
	$result = array();
	$i = 0;
	
	foreach ($notes as $notebook) {
		$n = $notebook->countAnnotations();
		$annos = $notebook->getAnnotations('', $n);
		$result[$i] = array();
		foreach ($annos as $anno) {
			$result[$i][$anno->name] = $anno->value;
		}
		$i++;
	}
	
	header("Content-Type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo json_encode($result);
	
?>