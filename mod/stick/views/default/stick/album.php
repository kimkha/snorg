<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	global $CONFIG;
	
	$images = get_entities_from_relationship(_STICK_PHOTO_RELATIONSHIP_, 1);
	
	$title = elgg_echo('stick:ititle');
	$desc = elgg_echo('stick:idescription');
	$url = $CONFIG->wwwroot . "pg/stick/album";
	
?>
<div class="stick-album">
<?php
	
	echo "<div id='content_area_user_title'><h2><a href='" . $CONFIG->wwwroot . "pg/stick/album'>" . $title . "</a></h2></div>";
	
	echo "<div id='tidypics_desc'>" . autop($desc) . "</div>";
	
	//build array for back | next links 
	$_SESSION['image_sort'] = array();
?>
<div class='stick-photo-wrapper'>
<?php
	if (is_array($images)) {
		foreach ($images as $image) {
			array_push($_SESSION['image_sort'], $image->guid);
		}
		
		$offset = (int) get_input('offset', 0);
		$limit = 24;
		if (get_context() == "index") {			$limit = 8;		}
		// display the simple image views. Uses 'object/image' view
		$ent = array();		for ($i=$offset; $i<($limit+$offset) && isset($images[$i]); $i++) {			$ent[] = $images[$i];		}
		echo elgg_view_entity_list($ent, count($images), $offset, $limit, false);
		
		$num_images = count($images);
	} else {
		echo '<div class="tidypics_info">' . sprintf(elgg_echo('stick:noimage'), $CONFIG->wwwroot."pg/photos/world/") . '</div>';
		$num_images = 0;
	}
	
?>
	<div class="clearfloat"></div>
<?php
	if (get_context() == "index") {
		echo "<div class='stick-album-viewall'><a href='" . $CONFIG->wwwroot . "pg/stick/album'>" . elgg_echo("stick:viewall") . "</a></div>";
		echo '<div class="clearfloat"></div>';
	}
?>
	</div>
</div>