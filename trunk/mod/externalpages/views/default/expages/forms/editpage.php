<?php

	global $CONFIG;
	$entity = $vars['entity'];
	
	$action = $CONFIG->wwwroot."action/expages/page";
	
	$options_parent = array('1'=>'Root');
	expages_parent_tree($options_parent, 1, '- ', '- - ');
	
	if ($entity) { // Want to edit
		$page_title = $entity->title;
		$guid = $entity->guid;
		$title = $entity->title;
		$description = $entity->description;
		$parent = $entity->container_guid;
		
		// remove current item
		unset($options_parent[$guid]);
	}
	else { // Want create new
		$page_title = elgg_echo('expages:create');
		$guid = 0;
		$title = '';
		$description = '';
		$parent = 1;
	}
	
	$input_title = elgg_view('input/text', array('internalname' => 'title', 'value' => $title));
	$input_area = elgg_view('input/longtext', array('internalname' => 'content', 'value' => $description));
	$pulldown_parent = elgg_view('input/pulldown', array('internalname' => 'parent', 'value' => $parent, 'options_values' => $options_parent, 'js'=>'size="5"'));
	$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('save')));
	if ($guid != 0) 
		$hidden_guid = elgg_view('input/hidden', array('internalname' => 'guid', 'value' => $guid));
		
	$parent_label = elgg_echo('parent');
	
	$form_body = <<<EOT

		<h3 class='settings'>$page_title</h3>
		<p>$input_title</p>
		<p class='longtext_editarea'>$input_area</p>
		<p>
			$parent_label<br />
			$pulldown_parent
		</p>
			$hidden_guid
			<br />
			$submit_input

EOT;
	
	//display the form
	echo elgg_view('input/form', array('action' => $action, 'body' => $form_body));
?>