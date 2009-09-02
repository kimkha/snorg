<?php
	/**
	 * @author Snow.Hellsing <snow@g7life.com>
	 * @copyright FireBloom Studio
	 * @link http://firebloom.cc
	 */
	/**
	 * return profile config
	 * which profile field is a ElggObject
	 * built by profilefield() of package ImporovedProfile
	 *
	 * @return array
	 */
	function get_profile_conf() {
		/**
		 * setup the order of four default category of profile
		 */
		$profile_conf = array('basic' => array(),'personal' => array(),'contact' => array(),'profession' => array());
		/**
		 * get all profile items
		 */
		$items = array(
			'gender' => ProfileItem(
				'gender',
				'pulldown',
				'basic',
				FALSE,
				array(
					'' => elgg_echo('unselected'),
					'female' => elgg_echo('profile:female'),
					'male' => elgg_echo('profile:male'),
					)
				),
			'birthday' => ProfileItem(
				'birthday',
				'date',
				'basic'
				),
			'hometown' => ProfileItem(
				'hometown',
				'tags',
				'basic'
				),
			'relationship_status' => ProfileItem(
				'relationship_status',
				'pulldown',
				'basic',
				FALSE,
				array(
					'' => elgg_echo('unselected'),
					'single' => elgg_echo('profile:single'),
					'in_relationship' => elgg_echo('profile:in_relationship'),
					'engaged' => elgg_echo('profile:engaged'),
					'married' => elgg_echo('profile:married'),
					'hard_to_tell' => elgg_echo('profile:hard_to_tell'),
					)
				),
			//personal information
			'interests' => ProfileItem(
				'interests',
				'tags',
				'personal'
				),
			'description' => ProfileItem(
				'description',
				'longtext',
				'personal'
				),
			'goal' => ProfileItem(
				'goal',
				'text',
				'personal'
				),
			//contact
			'mobile' => ProfileItem(
				'mobile',
				'text',
				'contact',
				TRUE
				),
			'qq' => ProfileItem(
				'qq',
				'text',
				'contact',
				TRUE
				),
			'msn' => ProfileItem(
				'msn',
				'text',
				'contact'
				),
			'email' => ProfileItem(
				'email',
				'email',
				'contact',
				TRUE
				),
			'phone' => ProfileItem(
				'phone',
				'text',
				'contact'
				),
			'location' => ProfileItem(
				'location',
				'text',
				'contact'
				),
			'website' => ProfileItem(
				'website',
				'url',
				'contact',
				TRUE
				),
			//profession
			'profession' => ProfileItem(
				'profession',
				'tags',
				'profession'
				),
			'company' => ProfileItem(
				'company',
				'text',
				'profession'
				),
			'position' => ProfileItem(
				'position',
				'tags',
				'profession'
				),
			'college' => ProfileItem(
				'college',
				'tags',
				'profession'
				),
			'course' => ProfileItem(
				'course',
				'tags',
				'profession'
				),
		);		
		/**
		 * put them into the config array
		 */
		foreach ($items as $item) {
			$profile_conf[$item->category][$item->title] = $item;
		}
		return $profile_conf;
	}//function get_pyb_profile_config()
?>