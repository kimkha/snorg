<?php
	/**
	 * Improved Profile plugin
	 * uses an ElggObject based configure way
	 * added pulldown type to fields
	 * added datepulldown input
	 *
	 * @author KimKha
	 * @package SNORG
	 */	
	/*
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */

	$english = array(
	
		'unselected' => 'Please select:',
		'profile:toggle_details' => 'Show/Hide Details',
		
		#profile
		#section:basic
		'profile:category:basic' => 'Basic Info',
		'profile:gender' => 'Gender',
		'profile:female' => 'Female',
		'profile:male' => 'Male',
		'profile:hometown' => 'Hometown',
		#birthday
		'profile:birthday' => 'Birthday',
		'year' => 'Year',
		'month' => 'Month',
		'day' => 'Day',
		'profile:birthday:show_year' => 'Show birth year-month-day in profile',
		'profile:birthday:hide_year' => 'Only show month and day in profile',
		'profile:goal' => 'Goal',
		'profile:msn' => 'MSN',
		#relationship
		'profile:relationship_status' => 'Relationship Status',
		'profile:single' => 'Single',
		'profile:in_relationship' => 'In a Relationship',
		'profile:engaged' => 'Engaged',
		'profile:married' => 'Married',
		'profile:hard_to_tell' => 'It\'s Complicated',
		'profile:open_relationship' => 'In an Open Relationship',	
		#personal
		'profile:category:personal' => 'Personal Info',		
		#contact
		'profile:category:contact' => 'Contact Info',
		'profile:yahoo' => 'Yahoo',
		'profile:facebook' => 'Facebook',
		'profile:skype' => 'Skype',
		'profile:email' => 'Email',		
		#profession
		'profile:category:profession' => 'Profession Info',
		'profile:profession' => 'Profession',
		'profile:company' => 'Company',
		'profile:position' => 'Position',
		'profile:college' => 'College',
		'profile:course' => 'Course',
			
		'DataFormatException:invalid_input_format' => '%s had an invalid format',
		'DataFormatException:field_required' => 'Please input %s',
		'DataFormatException:empty_input' => 'This site met a technologic problem.Please report to the admin',
		'BusinessLogicException:unique_meta_duple' => 'Someone else on this site had already own this %s',
		'ConfigurationException:invalid_profile_config' => 'Invalid profile configuration.If you see this,please tell the site admin.',
	);

	add_translation("en",$english);
?>