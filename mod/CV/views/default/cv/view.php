<?php 
	global $CONFIG;
	$login_user = get_loggedin_user();
	
	$page_owner = page_owner_entity();
	
	if ($login_user->guid == $page_owner->guid){
	
 ?>
		<div id='btnEditCV' class="profile_info_edit_buttons" align="right"> <a href="<?php echo $CONFIG->wwwroot ?>mod/cv/edit.php?username=<?php echo $page_owner->name; ?>">Edit CV</a></div> 
<?php
	}
	if (is_array($vars['config']->cv) && sizeof($vars['config']->cv) > 0)
		
		foreach($vars['config']->cv as $label => $valtype) {
			
			if ($metadata = get_metadata_byname(page_owner_entity()->guid, $label)) {
				$value = '';
				
				if (is_array($metadata)) {
					foreach($metadata as $md) {
						$value .= $md->value;
						$access_id = $md->access_id;
					}
				} else {
					$value .= $metadata->value;
					$access_id = $metadata->access_id;
				}
				
			} else {
				
				$value = '';
				$access_id = ACCESS_DEFAULT;
			}

?>

	<p class="CV-detail">
		<label>
			<?php echo elgg_echo($label) ?> 
		</label>
			<?php echo $value; ?>  
			
	</p>

<?php

		}

?>

	
