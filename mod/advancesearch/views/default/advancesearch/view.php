<?php

	/**
	 * Advance search
	 * Search users through them information
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>pg/advancesearch/result" method="get">

		<?php
		
	if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0) {
		
		foreach ($vars['config']->profile as $alltag) {
			unset($alltag['description']);
			unset($alltag['birthday']);
			foreach($alltag as $item) {
				$shortname = $item->title;
				$valuetype = $item->valuetype;
				$curr_field_category = $item->category;
			?>
	<p>
		<label>
			<?php echo elgg_echo("profile:{$shortname}") ?><br />
			<?php echo elgg_view("input/{$valuetype}",
									array(
										'internalname' => $shortname,
										'value' => $value,
										'options_values' => $item->options,
										)
									); ?>
		</label>
	</p>
			<?php
			
			}
		}
	}
		
		?>
	<p>
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("go"); ?>" />
	</p>

</form>
</div>
