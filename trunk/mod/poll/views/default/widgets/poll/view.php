<?php
	/**
	 * Elgg Poll plugin
	 * @package Elggpoll
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @Original author John Mellberg
	 * website http://www.syslogicinc.com
	 * @Modified By Team Webgalli to work with ElggV1.5
	 * www.webgalli.com or www.m4medicine.com
	 */
	 
	
	//get the num of polls the user want to display
	$limit = $vars['entity']->limit;
	
	$user = get_loggedin_user();
	
		
	//if no number has been set, default to 4
	if(!$limit) $limit = 3;
	
	//the page owner
	$owner_guid = $vars['entity']->owner_guid;
	
	$owner = page_owner_entity();
	
		echo "<div class=\"contentWrapper\">";
		echo "<h4>Let " . $owner->name . " know what you think!</h4>";
		echo "</div>";
	
	
		
	$polls = get_user_objects($owner_guid, 'poll', $limit, 0);
	if ($polls){
		
		
		
	//	echo "<pre>"; print_r($polls); die;
		foreach($polls as $pollpost) {
			
		echo elgg_view("poll/widget", array('entity' => $pollpost));
			
			//echo elgg_view("poll/forms/vote",array('entity' => $pollpost));
			
		$isPgOwner = ($vars['entity']->getOwnerEntity()->guid == $user->guid);
		
		$priorVote = checkForPreviousVote($pollpost, $vars['user']->guid);
		
				
		$alreadyVoted = 0;
		
        if ( $priorVote !== false ) {
          $alreadyVoted = 1;
        }
				
				
				//if user has voted, show the results
				if ( $alreadyVoted ) {
          		// show the user's vote
					
					echo elgg_view('poll/results',array('entity' => $pollpost));
				} else {
					
					//echo "<pre>"; print_r($priorVote); die;
					//else show the voting form
					echo elgg_view("poll/forms/vote",array('entity' => $pollpost));
					
				}
			
			
		}
	}
	else
	{
		echo "<div class=\"contentWrapper\">";
		echo "<p>" . $owner->name . " hasn't created a poll yet.</p>";
		echo "</div>";
	}
	
	
	//echo elgg_view("wlist/listing", array('entity' => $wishes));
	
?>