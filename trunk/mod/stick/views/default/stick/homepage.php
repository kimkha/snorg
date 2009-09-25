<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	global $CONFIG;
	$category = get_plugin_setting("blogcategory", "stick");
	if (!$category) $category = "Technical, Tourist, Company birthday";
	
	$array = explode(",", $category);
	$array = array_combine($array, $array);
	
?>
	<div id="ktabs_panel">
<?php
	foreach ($array as $key => $value) {
		$key = convert_whitespace($key);
		$value = trim($value);
		echo "<a href=\"".$CONFIG->wwwroot."action/stick/blog?category=".$key."\">".$value."</a>";
	}
?>
	</div>
	<div id="ktabs_content"></div>
