<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
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
<div class="commend-header"><?php echo elgg_echo('stick:user:month'); ?></div>
<div class="commend-img">
	<?php echo elgg_view("profile/icon", array( "entity"=>$user, "size"=>"medium", "align"=>"center" )); ?>
</div>
<div class="commend-title">
	<a href="<?php echo $CONFIG->wwwroot; ?>pg/stick/commend?id=<?php echo $last->guid; ?>"><?php echo $last->title; ?></a>
</div>
<div class="stick-commend-viewall"><a href='<?php echo $CONFIG->wwwroot; ?>pg/stick/commend'><?php echo elgg_echo("stick:viewall"); ?></a></div>
<div class="clearfloat"></div>
</div>
<?php
	}
	else {
		echo " ";
	}
?>