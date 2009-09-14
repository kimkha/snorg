
<?php

	$photo_tags = $vars['photo_tags'];
	$links = $vars['links'];
	$photo_tags_json = $vars['photo_tags_json'];
	$file_guid = $vars['file_guid'];
//	$viewer = $vars['viewer'];
//	$owner = $vars['owner'];

	//echo "<pre>"; print_r($file_guid); die;
	

	$viewer = get_loggedin_user();
	$entity_guid =  $vars['entity'];
	$entity = get_entity($entity_guid);
	$owner = get_entity($entity->owner_guid);
//	echo "<pre>"; print_r($entity); die;
	
//	echo $viewer->name();

?>

<script type="text/javascript" src="<?= $vars['url'] ?>vendors/taguser/jquery.quicksearch.js"></script>
 
<script type="text/javascript">

	
	var user_id = 0;


	// add to DOM as soon as ready
	$(document).ready(function () {
			$('ul#tidypics_phototag_list li').quicksearch({
				position: 'before',
				attached: 'ul#tidypics_phototag_list',
				loaderText: '',
				inputClass: 'input-filter',
				labelText: "<p><?php echo elgg_echo('tidypics:tagthisphoto'); ?></p>",
				delay: 100
			});

			$("#tidypics_phototag_list").css("display", "none");
			
			$("#quicksearch .input-filter").keyup(function(){
				if ($(this).val() == '') {
					$("#tidypics_phototag_list").css("display", "none");
				}
				else {
					$("#tidypics_phototag_list").css("display", "block");
									
				}
			});

			$('#quicksearch').submit( function () { addTag() } );
		}
	);



	// get tags over image ready for mouseover
	// based on code by Tarique Sani <tarique@sanisoft.com> - MIT and GPL licenses


	function selectUser(id, name) 
	{
		user_id = id;
		$("input.input-filter").val(name);
	}

	function addTag()
	{
		// do I need a catch for no tag?

		$("input#user_id").val(user_id);
			$("input#coordinates").val(coord_string);

		//Show loading
		//$("#tag_menu").replaceWith('<div align="center" class="ajax_loader"></div>');
	}


</script>
<?php
	
	if($viewer == $owner) {
		$friends = get_entities_from_relationship('friend', $viewer->getGUID(), false, 'user', '', 0, 'time_created desc', 1000);
		
		if ($friends) {
			foreach($friends as $friend) {
				$friend_array[$friend->name] = $friend->getGUID();
			}
		}
		ksort($friend_array);

		$content = "<input type='hidden' name='image_guid' value='{$entity_guid}' />";
		$content .= "<input type='hidden' name='user_id' id='user_id' value='' />";
			
		$content .= "<ul id='tidypics_phototag_list'>";
		$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($friends) {
			foreach($friend_array as $friend_name => $friend_guid) {
				$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$friend_guid}, \"{$friend_name}\")'>{$friend_name}</a></li>";
			}
		}
		
			$content .= "</ul>";

	$content .= "<input type='submit' value='" . elgg_echo('tidypics:actiontag') . "' class='submit_button' />";
	
	//echo "hoai";
	
	
	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'tidypics_phototag_form', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/taguser/tag", 'body' => $content));
	}

	


	
	
   if( $friends = $entity->getAnnotations('taguser'))
   {
   	  	 
 //  	 print_r($friends); die;
   	 
   	 $friends = array_unique_by_attribute($friends, "owner_guid");
   	  // print_r($friends); die;
   	 
   	 //$friends = array_unique($friend->owner_guid);
   	 
   	/* echo "<pre>"; print_r($friends); die;
   	 
   	 	echo "Who was tagged In: <br>";
		echo "<div id=\"widget_friends_list\">";
		
		foreach($otherUser as $taggeduser) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			
			echo elgg_view("profile/icon",array('entity' => get_user($taggeduser), 'size' => 'small'));
			
			echo '<p><a href="'. $vars['url'] . 'action/taguser/untag?user_guid=' . $user->getGUID() . '&event_guid='.$guid.'&__elgg_token=' . $token . '&__elgg_ts=' . $ts . '">Attend</a> | ';
			
		//	echo '<a onclick=delete_annotation('.$taggeduser}.')>DELETE</a>'
			//echo "<br";
			
			//echo get_user($taggeduser);
		
		echo "</div>";
		}

		echo "</div>";
  	// echo "<pre>"; print_r($friends); die;
  	
  	
  	
   	 $otherUser = array();
   	 $annotation_id = array();
   	 
   	 
	 foreach ($friends as $friend) {
						$otherUser[] = $friend->owner_guid;
											
		}

	foreach ($friends as $friend) {
						$annotation_id[] = $friend->id;
											
		}
	
	//	echo "<pre>"; print_r($annotation_id); die;
		
				
		$otherUser = array_unique($otherUser);
	
		echo "Who was tagged In: <br>";
	
		
		$i = -1;
	*/
		
		
		echo "<div id=\"widget_friends_list\">";	
		foreach($friends as $taggeduser) {
			
		
			//echo "<div class=\"widget_friends_singlefriend\" >";
			
		//	echo list_entities($taggeduser);
			echo elgg_view("profile/icon",array('entity' => get_user($taggeduser->owner_guid), 'size' => 'small'));
			//echo "<pre>"; print_r($annotation_id[]); die;
			echo '<p><a href="'. $vars['url'] . 'action/taguser/untag?annotation_id=' . $taggeduser->id .'">Remove Tag</a>';
			
	
		
	//	echo "</div>";
		
		}

		echo "</div>";
		echo "<br";
		
	
   	 
   	 echo $friends;
   	 system_message("hoai");
   
		//echo $friends->name();
		//echo "<pre>"; print_r($friends); die;
	
}
?>