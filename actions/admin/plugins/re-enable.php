<?php
	/**
	 * Re-enable plugin
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
	
	// block non-admin users
	admin_gatekeeper();
	
	// Validate the action
	action_gatekeeper();
	
	// Get the plugin 
	$plugin = get_input('plugin');
	if (!is_array($plugin))
		$plugin = array($plugin);
	
	foreach ($plugin as $p)
	{
		// Disable
		if (disable_plugin($p)) {
			if (enable_plugin($p)) {
				system_message(sprintf(elgg_echo('admin:plugins:re-enable:yes'), $p));
			}
			else
				register_error(sprintf(elgg_echo('admin:plugins:re-enable:no'), $p));
		}
		else
			register_error(sprintf(elgg_echo('admin:plugins:re-enable:no'), $p));
	}		
	
	elgg_view_regenerate_simplecache();
	
	$cache = elgg_get_filepath_cache();
	$cache->delete('view_paths');
		
	forward($_SERVER['HTTP_REFERER']);
	exit;
?>