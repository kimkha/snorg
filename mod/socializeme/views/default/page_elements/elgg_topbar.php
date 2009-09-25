<?php

	/**
	 * Elgg top toolbar
	 * The standard elgg top toolbar
	 * 
	 */
?>

<?php
     if (isloggedin()) {
?>

<div id="elgg_topbar">

<div id="elgg_topbar_container_left">
	<div class="toolbarimages">
		<a href="http://www.elgg.org" target="_blank"><img src="<?php echo $vars['url']; ?>mod/socializeme/graphics/elgg_toolbar_logo.png" /></a>
	</div>
	<div class="toolbarlinks">
		<a href="<?php echo $_SESSION['user']->getURL(); ?>" class="pagelinks"><?php echo splitname($_SESSION['user']->name, 20); ?></a>
	</div>
	<div class="toolbarlinks">
		<a href="<?php echo $vars['url']; ?>pg/dashboard/" class="pagelinks"><?php echo elgg_echo('dashboard'); ?></a>
	</div>
        <?php

	        echo elgg_view("navigation/topbar_tools");

        ?>
        	
        	
        <div class="toolbarlinks2">		
		<?php
		//allow people to extend this top menu
		echo elgg_view('elgg_topbar/extend', $vars);
		?>
		
		<a href="<?php echo $vars['url']; ?>pg/settings/" class="usersettings"><?php echo elgg_echo('settings'); ?></a>
		
		<?php
		
			// The administration link is for admin or site admin users only
			if ($vars['user']->admin || $vars['user']->siteadmin) { 
		
		?>
		
			<a href="<?php echo $vars['url']; ?>pg/admin/" class="usersettings"><?php echo elgg_echo("admin"); ?></a>
		
		<?php
		
				}
		
		?>
	</div>


</div>


<div id="elgg_topbar_container_right">
<div id="elgg_topbar_container_search">
<form id="searchform" action="<?php echo $vars['url']; ?>search/" method="get">
	<input type="text" size="21" name="tag" value="Search" onfocus="if (this.value=='Search') { this.value='' }" onblur="if (this.value=='') { this.value='Search' }" class="search_input" />
	<input type="submit" value="Go" class="search_submit_button" />
</form>
</div>
	<div id="elgg_topbar_container_logout">
		<a href="<?php echo $vars['url']; ?>action/logout"><small><?php echo elgg_echo('logout'); ?></small></a>
	</div>
</div>


</div><!-- /#elgg_topbar -->

<div class="clearfloat"></div>

<?php } else { ?>
<div id="elgg_topbar">

<div id="home-elgg_topbar_container_left">
	<div class="toolbarimages">
		       	
        	
        <div class="toolbarlinks2">	</div>	
	
	</div>


</div>


<div id="elgg_topbar_container_right">

<div style="float:right;" id="elgg_topbar_container_search">
<form id="searchform" action="<?php echo $vars['url']; ?>search/" method="get">
	<input type="text" size="21" name="tag" value="Search" onclick="if (this.value=='Search') { this.value='' }" class="search_input" />
	<input type="submit" value="Go" class="search_submit_button" />
</form>
</div>
</div>

</div><!-- /#elgg_topbar -->


<div class="clearfloat"></div>


<?php

    }
?>

