<?php

     /**
	 * Elgg login form
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	 
	global $CONFIG;
	
	$form_body = "<p class=\"loginbox\" id=\"loginbox\"><label>" . elgg_view('input/text', array('internalname' => 'username', 'class' => 'login-textarea')) . "</label>";
	$form_body .= "<br />";
	$form_body .= "<label>" . elgg_view('input/password', array('internalname' => 'password', 'class' => 'login-textarea')) . "</label><br />";
	$form_body .= " <div id=\"persistent_login\"><label><input type=\"checkbox\" name=\"persistent\" value=\"true\" />".elgg_echo('user:persistent')."</label></div>";
	$form_body .= elgg_view('input/submit', array('value' => elgg_echo('login'))) . "<div class=\"clear-float\"></div></p>";
	$form_body .= "<p class=\"loginbox\">";
	$form_body .= (!isset($CONFIG->disable_registration) || !($CONFIG->disable_registration)) ? "<a href=\"{$vars['url']}account/register.php\">" . elgg_echo('register') . "</a> | " : "";
	$form_body .= "<a href=\"{$vars['url']}account/forgotten_password.php\">" . elgg_echo('user:password:lost') . "</a></p>";  
	
	//<input name=\"username\" type=\"text\" class="general-textarea" /></label>
	
	$login_url = $vars['url'];
	if ((isset($CONFIG->https_login)) && ($CONFIG->https_login))
		$login_url = str_replace("http", "https", $vars['url']);
?>
<script>
var login_username_img = "<?php echo $CONFIG->wwwroot; ?>_graphics/login-username.png";
var login_password_img = "<?php echo $CONFIG->wwwroot; ?>_graphics/login-password.png";
var login_username_focus = false;
var login_password_focus = false;
function hide_login_input(myinput, type) {
	eval("var mytype = login_"+type+"_img");
	eval("var myfocus = login_"+type+"_focus");
	
	myinput.css("background-position", "top left");
	myinput.css("background-repeat", "no-repeat");
	myinput.css("background-image", "url('"+mytype+"')");
	
	myinput.focus(function(){
		if (!myfocus) {
			myfocus = true;
			$(this).css("background-image", "none");
		}
	});
	
	myinput.blur(function(){
		if ($(this).val() == '') {
			myfocus = false;
			$(this).css("background-image", "url('"+mytype+"')");
		}
	});
}
$(document).ready(function(){
	hide_login_input($("#loginbox input[type='text']"), 'username');
	hide_login_input($("#loginbox input[type='password']"), 'password');
});
</script>
	
	<div id="login-box">
	<h2><?php echo elgg_echo('login'); ?></h2>
		<?php 
			echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$login_url}action/login"));
		?>
		
	</div>