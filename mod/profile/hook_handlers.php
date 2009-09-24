<?php
	function profile_update_preprocess($hook, $entity_type, $returnvalue, $params) {
		/*
		 * format check
		 */
		if ('' != $params['website']) {
			if (is_url($params['website'])) {
				$params['website'] = preprocess_url($params['website']);
			}else {
				throw new DataFormatException(sprintf(elgg_echo('DataFormatException:invalid_input_format'),elgg_echo('profile:website')));
			}
		}
		/*
		 * check if in input qq,mobile,website is unique in this site
	 	 * or own by the user her/him self
		 */
		global $CONFIG;
		foreach ($CONFIG->profile as $item){
			if ( !empty($params[$item->title]) && $item->isUnique && is_meta_value_exsits($item->title,$params[$item->title])) {
				throw new BusinessLogicException( sprintf(elgg_echo("BusinessLogicException:unique_meta_duple"),elgg_echo("profile:{$item->title}")) );
			}
		}
		return $params;
	}
?>