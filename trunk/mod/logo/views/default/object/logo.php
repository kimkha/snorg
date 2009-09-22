<?php
	/**
	 * Elgg Logo Browser
	 * File renderer.
	 * 
	 * @package ElggFile
	 * @author bkit06
	 * @copyright snorg 2009
	 * @link http://bkitclub.net
	 */

	global $CONFIG;
	
	$file = $vars['entity'];
//	echo "<pre>"; print_r($file); die;
	
	$file_guid = $file->getGUID();
	$tags = $file->tags;
	$title = $file->title;
	$desc = $file->description;
	$owner = $vars['entity']->getOwnerEntity();
	$friendlytime = friendly_time($vars['entity']->time_created);
	$mime = $file->mimetype;
		
	if (get_context() == "search") { 	// Start search listing version 
		
			$info = "<p> <a href=\"{$file->description}\">{$title}</a></p>";
			$info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/logo/{$owner->username}\">{$owner->name}</a> {$friendlytime} </p>";			
					
		

	if ($file->canEdit()) {
	
				$info .='<a href="'.$vars['url'].'mod/logo/edit.php?file_guid='.$file->getGUID().'">'.elgg_echo('edit').'</a>&nbsp'; 
					
					$info .= elgg_view('output/confirmlink',array(
						
							'href' => $vars['url'] . "action/logo/delete?file=" . $file->getGUID(),
							'text' => elgg_echo("delete"),
							'confirm' => elgg_echo("file:delete:confirm"),
						
						));  
	
				
	}
	
	//Small Icon Logo
		$icon = "<a href=\"{$file->description}\">" . elgg_view("logo/icon", array("mimetype" => $mime, 'thumbnail' => $file->thumbnail, 'file_guid' => $file_guid)) . "</a>";
		
		

echo elgg_view_listing($icon, $info);

}
		
?>