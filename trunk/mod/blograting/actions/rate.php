<?php

	$rate_point = get_input('rating');
	$rate_userid = get_input('user');
	$rate_entryid = get_input('entity');
	
	$rate_entry = get_entity($rate_entryid);
	
	if (!$rate_entry->ratecount){
		$rate_entry->ratecount = 0;
	}
	if (!$rate_entry->ratetotal){
		$rate_entry->ratetotal = 0;
	}
	if (!$rate_entry->rateaverage){
		$rate_entry->rateaverage = 0;
	}
	
	$rate_entry->ratecount += 1;
	$rate_entry->ratetotal += $rate_point;
	$rate_entry->rateaverage = $rate_entry->ratetotal/ $rate_entry->ratecount;
	
	if (!$rate_entry->rateusers){
		$rate_entry->rateusers = '-'.$rate_userid.'-';
	} else {
		$rate_entry->rateusers .= $rate_userid;
		$rate_entry->rateusers .= '-';
	}
	
	$rate_entry->save();
	
	$user = $rate_entry->getOwnerEntity();
	
	// update top rated user's rating entries 
	
	$top_entries = get_entities_order_by_metadata('object','blog',$user->guid,'ratetotal',5);
	
	$topentries = '<ol>';
	foreach ($top_entries as $entry){
		
		$topentries.= "<li><a href=\"". $entry->getURL() . "\">". $entry->title . "</a> +{$entry->ratetotal} | " . substr($entry->rateaverage,0,3) . "</li> ";
	}
	$topentries .= '</ol>'; 
	create_metadata($user->guid, 'TOP ENTRIES', $topentries, 'text', $user->guid, ACCESS_PUBLIC);
	
	$result = array();
	$result['average'] = $rate_entry->rateaverage;
	$result['total'] = "<i>(" .sprintf(elgg_echo('blograting:summary'), $rate_entry->ratecount). ")</i>";
	
	header("Content-Type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	echo json_encode($result);
	
	exit();
?>

