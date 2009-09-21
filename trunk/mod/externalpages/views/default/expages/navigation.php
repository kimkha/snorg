<?php
	
	
	
	// get all pages
	$list = get_entities("object", "expages", 0, "", 0, 0, false, 0, 1);
	
	foreach ($list as $expage) {
		// View menu
?>
	<li class="drop"><a class="menuitemtools" href="<?php echo expages_url(); ?>read/<?php echo $expage->guid; ?>"><span><?php echo $expage->title; ?></span></a>
<?php
		// get submenu
		$sublist = get_entities("object", "expages", 0, "", 0, 0, false, 0, $expage->guid);
		if (!$sublist) continue;
		echo "<ul>";
		foreach ($sublist as $ex) {
			echo "<li><a href='".expages_url()."read/".$ex->guid."'>".$ex->title."</a></li>";
		}
		echo "</ul></li>";
	}
?>