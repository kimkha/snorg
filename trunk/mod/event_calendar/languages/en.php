<?php

	$english = array(
	
	'item:object:event_calendar' => "Event calendar",
	'event_calendar:new_event' => "New event",
	'event_calendar:no_such_event_edit_error' => "Error: There is no such event or you do not have permission to edit it.",
	'event_calendar:add_event_title' => "Add event",
	'event_calendar:manage_event_title' => "Edit event",
	'event_calendar:manage_event_description' => "Enter the details of your event below. "
		."The title, venue, and start date are required. "
		."You can click on the calendar icons to set the start and end dates.",
	'event_calendar:title_label' => "Title",
	'event_calendar:title_description' => "Required. One to four words",
	'event_calendar:brief_description_label' => "Brief description",
	'event_calendar:brief_description_description' => "Optional. A short phrase.",
	'event_calendar:venue_label' => "Venue",
	'event_calendar:venue_description' => "Required. Where will this event be held?",
	'event_calendar:start_date_label' => "Start date",
	'event_calendar:start_date_description'	=> "Required. When will this event start?",
	'event_calendar:end_date_label' => "End date",
	'event_calendar:end_date_description'	=> "Optional. When will this event end? The start date will be "
		."used as the end date if this is not supplied.",
	'event_calendar:fees_label' => "Fees",
	'event_calendar:fees_description'	=> "Optional. The cost of this event, if any.",
	'event_calendar:contact_label' => "Contact",
	'event_calendar:contact_description'	=> "Optional. The person to contact for more information, "
			."preferably with a telephone number or email address.",
	'event_calendar:organiser_label' => "Organiser",
	'event_calendar:organiser_description'	=> "Optional. The individual or organisation responsible for this event.",
	'event_calendar:event_tags_label' => "Tags",
	'event_calendar:event_tags_description'	=> "Optional. A comma-separated list of tags relevant to this event.",
	'event_calendar:long_description_label' => "Long description",
	'event_calendar:long_description_description'	=> "Optional. Can be a paragraph or more as required.",
	'event_calendar:manage_event_response' => "Your event has been saved.",
	'event_calendar:add_event_response' => "Your event has been added.",
	'event_calendar:manage_event_error' => "Error: There was an error in saving your event. "
			."Please make sure that you have provided the required fields.",
	'event_calendar:show_events_title' => "Event calendar",
	'event_calendar:day_label' => "Day",
	'event_calendar:week_label' => "Week",
	'event_calendar:month_label' => "Month",
	'event_calendar:group' => "Group calendar",
	'event_calendar:new' => "Add event",
	'event_calendar:submit' => "Submit",
	'event_calendar:cancel' => "Cancel",
	'event_calendar:widget_title' => "Event calendar",
	'event_calendar:widget:description' => "Displays your events.",
	'event_calendar:num_display' => "Number of events to display",
	'event_calendar:groupprofile' => "Upcoming events",
	'event_calendar:view_calendar' => "view calendar",
	'event_calendar:when_label' => "When",
	'event_calendar:site_wide_link' => "View all events",
	'event_calendar:view_link' => "View this event",
	'event_calendar:edit_link' => "Edit this event",
	'event_calendar:delete_link' => "Delete this event",
	'event_calendar:delete_confirm_title' => "Confirm event deletion",
	'event_calendar:delete_confirm_description' => "Are you sure that you want to delete this event (\"%s\")? This action cannot be undone.",
	'event_calendar:delete_response' => "This event has been deleted.",
	'event_calendar:error_delete' => "This event does not exist or you do not have the right to delete it.",
	'event_calendar:delete_cancel_response' => "Event delete cancelled.",
	'event_calendar:add_to_my_calendar' => "Add to my calendar",
	'event_calendar:remove_from_my_calendar' => "Remove from my calendar",
	'event_calendar:add_to_my_calendar_response' => "This event has been added to your personal calendar.",
	'event_calendar:remove_from_my_calendar_response' => "This event has been removed from your personal calendar.",
	'event_calendar:users_for_event_title' => "People interested in event \"%s\"'",
	'event_calendar:personal_event_calendars_link' => "Personal event calendars (%s)",
	'event_calendar:settings:group_profile_display:title' => "Group calendar profile display (if group calendars are enabled)",
	'event_calendar:settings:group_profile_display_option:left' => "left column",
	'event_calendar:settings:group_profile_display_option:right' => "right column",
	'event_calendar:settings:group_profile_display_option:none' => "none",
	'event_calendar:settings:autopersonal:title' => "Automatically add events a user creates to his/her personal calendar.",
	'event_calendar:settings:yes' => "yes",
	'event_calendar:settings:no' => "no",
	'event_calendar:settings:site_calendar:title' => "Site calendar",
	'event_calendar:settings:site_calendar:admin' => "yes, only admins can post events",
	'event_calendar:settings:site_calendar:loggedin' => "yes, any logged-in user can post an event",	
	'event_calendar:settings:group_calendar:title' => "Group calendars",
	'event_calendar:settings:group_calendar:admin' => "yes, only admins and group owners can post events",
	'event_calendar:settings:group_calendar:members' => "yes, any group member can post an event",
	'event_calendar:settings:group_default:title' => "New groups should by default have a group calendar (if group calendars are enabled)",
	'event_calendar:settings:group_default:no' => "no (but admins or group owners can turn a group calendar on if desired)",
	'event_calendar:settings:group_default:yes' => "yes (but admins or group owners can turn a group calendar off if desired)",
	'event_calendar:enable_event_calendar' => "Enable group event calendar",
	'event_calendar:no_events_found' => "No events found.",
			
	/**
	 * Event calendar river
	 **/
			 
	//generic terms to use
    'event_calendar:river:created' => "%s added",
    'event_calendar:river:updated' => "%s updated",
    'event_calendar:river:annotated1' => "%s added",
	'event_calendar:river:annotated2' => "to his/her personal calendar.",
	 
	//these get inserted into the river links to take the user to the entity
    'event_calendar:river:create' => "a new event titled",
    'event_calendar:river:the_event' => "an event titled",
    
    // snorg - bkit06 add more for invite people
    'event_calendar:invite'  =>  "Invite Friends",
    
    'event:notify:userinvited' => "Notify Sucessful",
    'event:notify:usernotinvited' => "Cannot sent notify",
    "event:usernotinvited" => "Cannot invite this user",
    "event:useralreadyinvited" => "This user has been invited",
    "event:notowner" => "Not permission",
	);
	
	
	
	
	
					
	add_translation("en",$english);

?>