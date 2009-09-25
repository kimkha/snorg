<?php

	/**
	 * Improve thewire plugin
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	 
	/**
	 * Elgg thewire edit/add page
	 * 
	 * @package ElggTheWire
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 */

		$wire_user = get_input('wire_username');
		if (!empty($wire_user)) { $msg = '@' . $wire_user . ' '; } else { $msg = ''; }

?>
<div class="post_to_wire">
<h3><?php echo elgg_echo("thewire:doing"); ?></h3>
<script>
var maxLength = -1;
function textCounter(field,cntfield) {
	if (maxLength < 0) maxLength = cntfield.value;
    // if too long...trim it!
    if (field.value.length > maxLength) {
        field.value = field.value.substring(0, maxLength);
    } else {
        // otherwise, update 'characters left' counter
        cntfield.value = maxLength - field.value.length;
    }
}
function submitnoteForm(thisForm){
	myForm = $(thisForm);
	value = "<?php echo $msg; ?>" + $("#thewire_tiny-textarea").val();
	$("#thewire_tiny-textarea").val(value);
	/*
	url = myForm.attr('action');
	$.post(url, myForm.serializeArray(), function(data){
		
	}, 'json');*/
}
</script>

	<form action="<?php echo $vars['url']; ?>action/thewire/add" method="post" name="noteForm" onsubmit="submitnoteForm(this);">
			<?php
			    $display .= "<textarea name='note' value='' onKeyDown=\"textCounter(document.noteForm.note,document.noteForm.remLen1)\" onKeyUp=\"textCounter(document.noteForm.note,document.noteForm.remLen1)\" id=\"thewire_large-textarea\"></textarea>";
                $display .= "<div class='thewire_characters_remaining'><input readonly type=\"text\" name=\"remLen1\" size=\"3\" maxlength=\"3\" value=\"140\" class=\"thewire_characters_remaining_field\">";
                echo $display;
                echo elgg_echo("thewire:charleft") . "</div>";
			?>
			<input type="hidden" name="method" value="site" />
			<input type="submit" value="<?php echo elgg_echo('save'); ?>" />
	</form>
</div>