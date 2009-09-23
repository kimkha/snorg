
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

<script type="text/javascript" src="<?php echo $vars['url'] ?>vendors/taguser/jquery.quicksearch.js"></script>
 
<script type="text/javascript">

	
	var user_id = 0;


	// add to DOM as soon as ready
	$(document).ready(function () {
			$('ul#phototag_list li').quicksearch({
				position: 'before',
				attached: 'ul#phototag_list',
				loaderText: '',
				inputClass: 'input-filter',
				labelText: "<p><b><?php echo elgg_echo('taguser:tagthisphoto'); ?></b></p><?php echo elgg_echo('taguser:chooseuser'); ?>",
			
				delay: 100
			});

			$("#phototag_list").css("display", "none");
			
			$("#quicksearch .input-filter").keyup(function(){
				if ($(this).val() == '') {
					$("#phototag_list").css("display", "none");
				}
				else {
					$("#phototag_list").css("display", "block");
									
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
			
		$content .= "<ul id='phototag_list'>";
	//	$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$viewer->getGUID()},\"{$viewer->name}\")'> {$viewer->name} (" . elgg_echo('me') . ")</a></li>";
	
		if ($friends) {
			foreach($friend_array as $friend_name => $friend_guid) {
				$content .= "<li><a href='javascript:void(0)' onclick='selectUser({$friend_guid}, \"{$friend_name}\")'>{$friend_name}</a></li>";
			}
		}
		
			$content .= "</ul>";

	$content .= "<input type='submit' value='" . elgg_echo('taguser:actiontag') . "' class='submit_button' />";
	
	//echo "hoai";
	
	
	echo elgg_view('input/form', array('internalid' => 'quicksearch', 'internalname' => 'tidypics_phototag_form', 'class' => 'quicksearch', 'action' => "{$vars['url']}action/taguser/tag", 'body' => $content));
	}

	


	
	
 if( $friends = $entity->getAnnotations('taguser'))
   {
   	  	 
 //  	 print_r($friends); die;
   	 
   	 $friends = array_unique_by_attribute($friends, "owner_guid");
   	  // print_r($friends); die;
   	 
   	 //$friends = array_unique($friend->owner_guid);
   	 

		echo "<p><b>".elgg_echo('taguser:usertaggedin')."</b></p>";
		
		echo "<div id=\"widget_friends_list\">";	
		foreach($friends as $taggeduser) {
			
		
			//echo "<div class=\"widget_friends_singlefriend\" >";
			
		
			echo elgg_view("profile/icon",array('entity' => get_user($taggeduser->owner_guid), 'size' => 'small'));
		
			if($viewer == $owner) {
			echo '<p><a href="'. $vars['url'] . 'action/taguser/untag?annotation_id=' . $taggeduser->id .'"> '.elgg_echo('taguser:remove').' </a></p>';
			
			};
		
				//	echo "</div>";
		
		}

		echo "</div>";
	
}
?>