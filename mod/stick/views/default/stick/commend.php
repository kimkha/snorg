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
	
	$time = 1;
	$timelower = time() - ($time * 30 * 24 * 60 * 60);
	$list = get_entities("object", _STICK_COMMEND_SUBTYPE_, 0, "", 1, 0, false, 0, null, $timelower);
	
	if ($list && is_array($list) && count($list)>0) {
		
		$last = $list[0];
		$user = get_entity($last->owner_guid);
	
?>
<div id="commend-box">
<div class="commend-header">Commended in this month</div>
<div class="commend-img">
	<?php echo elgg_view("profile/icon", array( "entity"=>$user, "size"=>"medium", "align"=>"center" )); ?>
</div>
<div class="commend-title">
	<a href="<?php echo $CONFIG->wwwroot; ?>pg/stick/commend?id=<?php echo $last->guid; ?>"><?php echo $last->title; ?></a>
</div>
</div>
<?php
	}
	else {
		echo " ";
	}
?>