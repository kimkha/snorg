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
		
		$offset = (int) get_input('offset');
		$limit = (int) get_input('index_limit', get_input('limit', 0));
		if ($limit == 0) $limit = 24;
		
		// display the simple image views. Uses 'object/image' view
		
		echo elgg_view_entity_list($images, count($images), $offset, $limit, false);
		
		$num_images = count($images);
	} else {
		echo '<div class="tidypics_info">' . sprintf(elgg_echo('stick:noimage'), $CONFIG->wwwroot."pg/photos/world/") . '</div>';
		$num_images = 0;
	}
	
?>
	<div class="clearfloat"></div>
<?php
	if (get_input("index_limit", 0) != 0) {
		echo "<div class='stick-album-viewall'><a href='" . $CONFIG->wwwroot . "pg/stick/album'>" . elgg_echo("stick:viewall") . "</a></div>";
		echo '<div class="clearfloat"></div>';
	}
?>
	</div>
</div>