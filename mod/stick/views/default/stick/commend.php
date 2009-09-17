<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	global $CONFIG;
	$list = get_entities("object", _STICK_COMMEND_SUBTYPE_, 0, "", 1);
	
	if (!$list) {
		echo " ";
		exit();
	}
	
	$last = $list[0];
	$user = get_entity($last->owner_guid);
	
?>
<div id="commend-box">
<div class="commend-img">
	<?php echo elgg_view("profile/icon", array( "entity"=>$user, "size"=>"medium", "align"=>"center" )); ?>
</div>
<div class="commend-title">
	<a href="<?php echo $CONFIG->wwwroot; ?>pg/stick/commend?id=<?php echo $last->guid; ?>"><?php echo $last->title; ?></a>
</div>
</div>