<?php

	/**
	 * Elgg hoverover extender for blog
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>pg/advancesearch/result" method="get">

		<?php
		
	if (is_array($vars['config']->profile) && sizeof($vars['config']->profile) > 0) {
		$alltag = $vars['config']->profile;
		unset($alltag['description']);
		foreach($alltag as $shortname => $valtype) {
			?>
	<p>
		<label>
			<?php echo elgg_echo("profile:{$shortname}") ?><br />
			<?php echo elgg_view("input/{$valtype}",array(
															'internalname' => $shortname,
															'value' => $value,
															)); ?>
		</label>
	</p>
			<?php
			
		}
	}
		
		?>
	<p>
		<input type="submit" class="submit_button" value="<?php echo elgg_echo("go"); ?>" />
	</p>

</form>
</div>
