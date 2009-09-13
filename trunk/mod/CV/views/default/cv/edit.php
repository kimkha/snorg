<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/cv/edit" method="post">

<?php


	if (is_array($vars['config']->cv) && sizeof($vars['config']->cv) > 0)
		
		foreach($vars['config']->cv as $lable => $valtype) {
			
			if ($metadata = get_metadata_byname($vars['entity']->guid, $lable)) {
				
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
			<?php echo elgg_echo($lable); ?>
			<?php $lable = str_replace(" ", "______", $lable); ?>
			<?php echo elgg_view("input/{$valtype}",array(
															'internalname' => $lable,
															'value' => $value,
															)); ?>
		</label>
			<?php echo elgg_view('input/access',array('internalname' => 'accesslevel['.$lable.']', 'value' => $access_id)); ?>
	</p>

<?php

		}

?>

	<p>
		<input type="hidden" name="username" value="<?php echo page_owner_entity()->username; ?>" />
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("save"); ?>" />
	</p>

</form>
</div>