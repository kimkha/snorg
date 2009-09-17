<?php

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

		$owner = page_owner_entity();
		$user = get_loggedin_userid();
		if ($user != $owner->guid) {
			$msg = '@' . $owner->username . ' ';
		} else {
			$msg = '';
		}

?>
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
	value = "<?php echo $msg; ?>" + $("#thewire_tiny-textarea").val();
	$("#thewire_tiny-textarea").val(value);
	
	myForm = $(thisForm);
	url = myForm.attr('action');
	$.post(url, myForm.serializeArray(), function(data){
		$(".profile_status").each(function(){
			$(this).html(data.status);
		});
		$("#thewire-tab").prepend(data.list);
		$("#wallpost").prepend(data.wall);
		$("#thewire_tiny-textarea").val('');
		$("#thewire_tiny-textarea").blur();
	}, 'json');
	return false;
}
function thewire_tiny_toggle() {
	var def = "<?php echo elgg_echo("thewire:tinydoing"); ?>";
	
	var thewire_tiny = $("#thewire_tiny");
	var textarea_thewire = $("#thewire_tiny-textarea");
	
	thewire_tiny.find(".thewire_characters_remaining").css("display", "none");
	thewire_tiny.find("input[type='submit']").css("display", "none");
	
	textarea_thewire.width(thewire_tiny.width()-12);
	textarea_thewire.height(17);
	
	textarea_thewire.focus(function(){
		textarea_thewire.css("height", "auto");
		thewire_tiny.find(".thewire_characters_remaining").css("display", "block");
		thewire_tiny.find("input[type='submit']").css("display", "inline");
		if ($(this).val() == def) {
			$(this).val('');
		}
	});
	
	textarea_thewire.blur(function(){
		if ($(this).val() == '') {
			textarea_thewire.css("height", "17px");
			thewire_tiny.find(".thewire_characters_remaining").css("display", "none");
			thewire_tiny.find("input[type='submit']").css("display", "none");
			$(this).val(def);
		}
	});
}
$(document).ready(function(){
	thewire_tiny_toggle();
});
</script>
<div class="post_to_wire" id="thewire_tiny">
	<form action="<?php echo $vars['url']; ?>action/thewire/add_tiny" method="post" name="noteForm" onsubmit="submitnoteForm(this);return false;">
		<textarea name='note' onkeydown="textCounter(document.noteForm.note,document.noteForm.remLen1)" onkeyup="textCounter(document.noteForm.note,document.noteForm.remLen1)" id="thewire_tiny-textarea"><?php echo elgg_echo("thewire:tinydoing"); ?></textarea>
		<div class='thewire_characters_remaining'>
			<input readonly="true" type="text" name="remLen1" size="3" maxlength="3" value="140" class="thewire_characters_remaining_field" /><?php echo elgg_echo("thewire:charleft") . "</div>"; ?>
			<input type="hidden" name="method" value="site" />
			<input type="hidden" name="owner" value="<?php echo $owner->guid; ?>" />
			<input type="submit" name="submit" value="<?php echo elgg_echo('save'); ?>" />
	</form>
</div>