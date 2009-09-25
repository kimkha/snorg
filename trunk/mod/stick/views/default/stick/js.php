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
	
	$category = get_plugin_setting("blogcategory", "stick");
	
	$array = explode(",", $category);
	$array = array_combine($array, $array);
	
	$options = "<select name='category'>";
	foreach ($array as $key => $value) {
		$key = convert_whitespace($key);
		$value = trim($value);
		$options .= "<option value='".$key."'>".$value."</option>";
	}
	$options .= "</select>";
	
	$save = "<input type='submit' value='".elgg_echo("stick")."' />";
	
	$form = "<form action='#' name='form_stick'>";
	$form .= elgg_echo('stick:category').": ".$options."<br />".$save;
	$form .= "</form>";
	
	$content = $form;
?>
<script type="text/javascript">
function stick_choose_category(link) {
	var l = $(link);
	var url = l.attr("href");
	
	var kbox = $kbox("<?php echo elgg_echo('stick:postit'); ?>", "<?php echo $content; ?>");
	$("form[name='form_stick']").submit(function (){
		var value = $(this).find("select[name='category']").val();
		url = url+"&category="+value;
		window.location.href = url;
		return false;
	});
	
	return false;
}
</script>
