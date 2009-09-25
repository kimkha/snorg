<?php
	/**
	 * Improved Profile plugin
	 * uses an ElggObject based configure way
	 * added pulldown type to fields
	 * added datepulldown input
	 *
	 * @author huyvtq
	 * @package SNORG
	 */

	global $CONFIG;
	$profile = $CONFIG->profile;
	$entity = $vars['entity'];

		if ($vars['entity']->guid == get_loggedin_userid()) {
?>
		<p class="profile_info_edit_buttons">
			<a href="<?php echo $vars['url']; ?>mod/profile/edit.php?username=<?php echo $vars['entity']->username; ?>"><?php echo elgg_echo("profile:edit"); ?></a>
		</p>
<?php
		}

	if (is_array($profile) && sizeof($profile) > 0){
		$even_odd = null;		
		foreach ($profile as $category) {
			foreach ($category as $item) {
				if ( '' == $entity->{$item->title}) {
					unset($profile[$item->category][$item->title]);
				}else{
					$item->value = $entity->{$item->title};
				}
			}
		}
		unset($profile['personal']['description']);
		unset($item);
		$profile = trigger_plugin_hook('profile:detailsview:preprocess','user',$profile,$profile);
		
		$last_field_category = '';
		foreach ($profile as $category) {
			foreach ($category as $item) {
				$shortname = $item->title;
				$valtype = $item->valuetype;
				$value = $item->value;
				/*
				 * display profile category title
				 */
				$curr_field_category = $item->category;
				if ($curr_field_category != $last_field_category) {
					echo "<p class=\"profile_category_title\" id=\"profile:category:$curr_field_category\">".elgg_echo("profile:category:$curr_field_category")."</p>";
				}
				/*
				 * display profile item
				 */
				$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
				echo "<p class=\"$even_odd\" id=\"profile:{$shortname}\"><b>".elgg_echo("profile:{$shortname}").": </b>";
				
				switch ($valtype) {
					default:
						echo elgg_view("output/{$valtype}",array('value' => $value));
					break;
					
					case 'pulldown':
						echo elgg_echo("profile:".elgg_view("output/{$valtype}",array('value' => $value)));
					break;
				}
				echo '</p>';
				$last_field_category = $curr_field_category;
			}
		}
	}//if (is_array($profile) && sizeof($profile) > 0)
?>