<?php
	/**
	 * Modified userdetials view to fit ElggObject based profile config
	 *
	 * @package ImprovedProfile
	 */
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * Elgg user display (details)
	 * 
	 * @package ElggProfile
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 * 
	 * @uses $vars['entity'] The user entity
	 */

	if ($vars['full'] == true) {
		$iconsize = "large";
	} else {
		$iconsize = "medium";
	}

?>
<div id="profile_info">
<table cellspacing="0">
<tr>
<td>

<?php	
	
	// wrap the icon and links in a div
	echo "<div id=\"profile_info_column_left\">";
	
	echo "<div id=\"profile_icon_wrapper\">";
	// get the user's main profile picture
	echo elgg_view(
						"profile/icon", array(
												'entity' => $vars['entity'],
												//'align' => "left",
												'size' => $iconsize,
												'override' => true,
											  )
					);


    echo "</div>";
    echo "<div class=\"clearfloat\"></div>";
     // display relevant links			
    echo elgg_view("profile/profilelinks", array("entity" => $vars['entity']));
/*
 * MOD START by Snow
 * Move aboutme to the left column
 *
 */
    echo '<p class="profile_aboutme_title"><b>'.elgg_echo("profile:aboutme").'</b></p>';
    if ($vars['entity']->isBanned()) {
    	echo '<div id="profile_banned">'.elgg_echo('profile:banned').'<div>';
    }else{
    	echo autop(filter_tags($vars['entity']->description)); 
    }
/*
 * MOD END by Snow
 */        
	echo "<div class='profile-leftbar'>".elgg_view("profile/leftbar", array("entity" => $vars['entity'])) ."</div>";
    // close profile_info_column_left
    echo "</div>";

?>
</td>
<td>
	
	<div id="profile_info_column_middle" >
<?php
			
	// Simple XFN
	$rel = "";
	if (page_owner() == $vars['entity']->guid)
		$rel = 'me';
	else if (check_entity_relationship(page_owner(), 'friend', $vars['entity']->guid))
		$rel = 'friend';
		
	// display the users name
	echo "<h2><a href=\"" . $vars['entity']->getUrl() . "\" rel=\"$rel\">" . $vars['entity']->name . "</a></h2>";

	//insert a view that can be extended
	echo elgg_view("profile/status", array("entity" => $vars['entity']));
	
	if (isloggedin() && ($vars['entity']->isFriendOf(get_loggedin_userid()) || $vars['entity']->guid == get_loggedin_userid()))
		echo elgg_view("thewire/forms/add_tiny", $vars);
	
/*	if ($vars['full'] == true) {
		echo elgg_view('profile/details',$vars);
	}	/**/
?>
	<div id="ktabs_panel">
	<?php echo elgg_view("profile/tabs", $vars); ?>
	</div>
	<div id="ktabs_content"></div>
	</div><!-- /#profile_info_column_middle -->

</td>
</tr>
</table>
</div><!-- /#profile_info -->
