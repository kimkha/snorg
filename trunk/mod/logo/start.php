<?php
	/**
	 * Snorg Logo Advertising
	 * 
	 * 
	 * @author bkit06
	 * @copyright snorg 2009
	 * @link http://bkitclub.net
	 */

	/**
	 * Override the ElggFile so that 
	 */
	class LogoPluginFile extends ElggFile
	{
		protected function initialise_attributes()
		{
			parent::initialise_attributes();
			
			$this->attributes['subtype'] = "logo";
		}
		
		public function __construct($guid = null) 
		{			
			parent::__construct($guid);
		}
	}
	

	/**
	 * File plugin initialisation functions.
	 */
	function logo_init() 
	{
		// Get config
		global $CONFIG;
				
		// Set up menu for logged in users
		if (isadminloggedin()) 
		{
			add_menu("Logo Adverstise", $CONFIG->wwwroot . "pg/logo/" . $_SESSION['user']->username);
		}
				
		// Extend CSS
		extend_view('css', 'logo/css');
		
	
		
		// Register a page handler, so we can have nice URLs
		register_page_handler('logo','logo_page_handler');
			
		// Add a new file widget
		add_widget_type('logo','Advertising',elgg_echo("file:widget:description"));
		
		// Register a URL handler for files
		register_entity_url_handler('logo_url','object','logo');
		


		// Register entity type
		register_entity_type('object','logo');
		
	}
	
	/**
	 * Sets up submenus for the file system.  Triggered on pagesetup.
	 *
	 */
	function logo_submenus() {
		
		global $CONFIG;
		
		$page_owner = page_owner_entity();
		
	
		// General submenu options
		
			if (get_context() == "logo") {
				if ( isadminloggedin()) {
					add_submenu_item(sprintf(elgg_echo("file:yours"),$page_owner->name), $CONFIG->wwwroot . "pg/logo/" . $page_owner->username);
				
				} 
				if (isadminloggedin())
					add_submenu_item(elgg_echo('file:upload'), $CONFIG->wwwroot . "pg/logo/". $page_owner->username . "/new/");
			}
		
	}

	/**
	 * File page handler
	 *
	 * @param array $page Array of page elements, forwarded by the page handling mechanism
	 */
	function logo_page_handler($page) {
		
		global $CONFIG;
		
		// The username should be the file we're getting
		if (isset($page[0])) {
			set_input('username',$page[0]);
		}
		
		if (isset($page[1])) 
		{
    		switch($page[1]) 
    		{
    			case "read":
    				set_input('guid',$page[2]);
					@include(dirname(dirname(dirname(__FILE__))) . "/entities/index.php");
				break;
    		
    			case "new":  
    				include($CONFIG->pluginspath . "logo/upload.php");
          		break;
    		}
		}
		else
		{
			// Include the standard profile index
			include($CONFIG->pluginspath . "logo/index.php");
		}
		
	}
	
	

	
	/**
	 * Returns a list of filetypes to search specifically on
	 *
	 * @param int|array $owner_guid The GUID(s) of the owner(s) of the files 
	 * @param true|false $friends Whether we're looking at the owner or the owner's friends
	 * @return string The typecloud
	 */

	
	/**
	 * Populates the ->getUrl() method for file objects
	 *
	 * @param ElggEntity $entity File entity
	 * @return string File URL
	 */
		function logo_url($entity) {
			
			global $CONFIG;
			$title = $entity->title;
			$title = friendly_title($title);
			return $CONFIG->url . "pg/logo/" . $entity->getOwnerEntity()->username . "/read/" . $entity->getGUID() . "/" . $title;
			
		}
	
	// Make sure test_init is called on initialisation
	register_elgg_event_handler('init','system','logo_init');
	register_elgg_event_handler('pagesetup','system','logo_submenus');
	
	// Register actions
	register_action("logo/upload", false, $CONFIG->pluginspath . "logo/actions/upload.php");
	register_action("logo/save", false, $CONFIG->pluginspath . "logo/actions/save.php");
	register_action("logo/download", true, $CONFIG->pluginspath. "logo/actions/download.php");
	register_action("logo/icon", true, $CONFIG->pluginspath. "logo/actions/icon.php");
	register_action("logo/delete", false, $CONFIG->pluginspath. "logo/actions/delete.php");
	
?>