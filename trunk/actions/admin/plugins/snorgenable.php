<?php
	/**
	 * Enable all recommended plugins by SNORG
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author KimKha
	 * @copyright SNORG
	 * @link http://elgg.org/
	 */

	require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
		
	// block non-admin users
	admin_gatekeeper();
	
	// Validate the action
	action_gatekeeper();
	
	$recommend = array(
		
		// Level 1
		'advancesearch',
		'blog',
		'blograting',
		'custom_index',
		'CV',
		'defaultwidgets',
		'diagnostics',
		'elggchat',
		'event_calendar',
		'externalpages',
		'fbconnect',
		'friends',
		'friends_of_friends', 
		'friend_request', 
		'groups', 
		'invitefriends',
		'logbrowser',
		'logo',
		'messageboard',
		'muturalfriends',
		'notebook',
		'notifications',
		'people_you_might_know',
		'poll',
		'profile',
		'riverdashboard',
		'sitenotification',
		'socializeme',
		'testimony',
		'thewire',
		'tidypics',
		'tinymce',
		'uservalidation',
		
		// Level 2
		'stick', // Must after blog, tydypics
	);
	
	$disable_plugins = get_installed_plugins();
	$enable_plugins = array();
	
	foreach ($recommend as $r) {
		if (!isset($disable_plugins[$r])) continue;
		$enable_plugins[$r] = $disable_plugins[$r];
		unset($disable_plugins[$r]);
	}
	
	foreach ($enable_plugins as $p => $data)
	{
		// Enable
		if (enable_plugin($p))
			system_message(sprintf(elgg_echo('admin:plugins:enable:yes'), $p));
		else
			register_error(sprintf(elgg_echo('admin:plugins:enable:no'), $p));
	}		
	
	foreach ($disable_plugins as $p => $data)
	{
		// Disable
		if (disable_plugin($p))
			system_message(sprintf(elgg_echo('admin:plugins:disable:yes'), $p));
		else
			register_error(sprintf(elgg_echo('admin:plugins:disable:no'), $p));
	}		
	
	// Regen view cache
	elgg_view_regenerate_simplecache();
	
	// Regen paths cache
	$cache = elgg_get_filepath_cache();
	$cache->delete('view_paths');
		
	forward($_SERVER['HTTP_REFERER']);
	exit;
	
?>