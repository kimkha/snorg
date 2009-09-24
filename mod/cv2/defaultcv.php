<?php
	
	require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
	
	admin_gatekeeper();
	set_context('admin');
	
	set_page_owner($_SESSION['guid']);
	
	$title = elgg_view_title(elgg_echo('cv:edit:default'));
	
	$form = elgg_view('cv/editdefaultcv');
	
			
	set_context('search');
	
	
	// List form elements
	$n = 0;
	$loaded_defaults = array();
	$listing = '';
	while ($translation = get_plugin_setting("admin_defined_cv_$n", 'cv'))
	{
		$type = get_plugin_setting("admin_defined_cv_type_$n", 'cv');
			
		$even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';					
	
		$listing .= "<p class=\"{$even_odd}\"><b>$translation:</b> [$type]";
		$listing .= "</p>";
		
		$n++;
	}
	
	if ($listing != '') {
		$listing = "<div class=\"contentWrapper cv-default\">" . $listing;
		
		if ($vars['disable_security']!=true)
		{
			$ts = time();
			$token = generate_action_token($ts);
			$security = '?__elgg_token='. $token;
			$security .= '&__elgg_ts=' . $ts;
		}
		
		$listing .= "<div class=\"resetdefaultprofile\">" . elgg_view("output/confirmlink",array(
								'href' => $CONFIG->wwwroot . 'action/cv/editdefault/reset'.$security,
								'text' => elgg_echo('cv:resetdefault'),
								'confirm' => elgg_echo('cv:confirmreset'),
								'ajax' => 'none',
				)
		) . "</div>";
		
		$listing .= "<div class='clearfloat'></div></div>";
	}
	
	set_context('admin');
	

	page_draw(elgg_echo('cv:edit:default'),elgg_view_layout("two_column_left_sidebar", '', $title . $form. $listing ));
	
?>