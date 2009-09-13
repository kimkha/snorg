<?php 
	global $CONFIG;
	$login_user = get_loggedin_user();
	
	$page_owner = page_owner_entity();
	
	if ($login_user->guid == $page_owner->guid){
	
 ?>
		<div id='btnEditCV' align="right"> <a href="<?php echo $CONFIG->wwwroot ?>mod/cv/edit.php?username=<?php echo $page_owner->name; ?>">Edit CV</a></div> 
<?php
	}
	if (is_array($vars['config']->cv) && sizeof($vars['config']->cv) > 0)
		
		foreach($vars['config']->cv as $lable => $valtype) {
			//echo "<pre>"; print_r($vars['config']->cv);die;
			if ($metadata = get_metadata_byname(page_owner_entity()->guid, $lable)) {
				
				if (is_array($metadata)) {
					$value = '';
					foreach($metadata as $md) {
						if (!empty($value)) $value .= ', ';
						$value .= $md->value;
						$access_id = $md->access_id;
					}
				} else {
					$value = $metadata->value;
					$access_id = $metadata->access_id;
				}
			} else {
				
				$value = '';
				$access_id = ACCESS_DEFAULT;
			}

?>

	<p>
		<label>
			<?php echo elgg_echo($lable) ?> 
			
		</label>
			<?php echo $value; ?>  
			
	</p>

<?php

		}

?>

	
