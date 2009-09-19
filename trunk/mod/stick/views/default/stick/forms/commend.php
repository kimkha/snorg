<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package ElggStick
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	
	admin_gatekeeper();
	
	$userId = $vars['userid'];
	$user = get_entity($userId);
	
	if (isset($vars['entity'])) {
		$entity = $vars['entity'];
		
		$update = elgg_view("input/hidden", array('internalname'=>'id', 'value'=>$vars['entity']->guid));
		$title = $entity->title;
		$description = $entity->description;
	}
	else {
		$update = '';
		$title = '';
		$description = '';
	}
	
	$body = "<p><label>Title: ".elgg_view('input/text', array('internalname'=>'title', 'value' => $title)) ."</label></p>";
	$body .= "<p><label>Description: ".elgg_view('input/longtext', array('internalname'=>'description', 'value' => $description))."</label></p>";
	$body .= elgg_view('input/hidden', array('internalname'=>'userid', 'value'=>$userId));
	$body .= $update;
	$body .= elgg_view('input/submit', array('internalname'=>'submit-commend', 'value'=>"Submit"));
	
	$action = $CONFIG->wwwroot . "action/stick/updatecommend";

	$content = elgg_view("input/form", array(
								'internalname' => 'commenduser',
								'body' => $body,
								'action' => $action
	));
	echo "<div id='commend-user-form'>".$content."</div>";
?>
