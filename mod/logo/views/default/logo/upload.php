<?php
	/**
	 * Elgg file browser uploader
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	global $CONFIG;
	
		if (isset($vars['entity'])) {
			$title = sprintf(elgg_echo("logo:edittitle"),$object->title);
			$action = "logo/save";
			$title = $vars['entity']->title;
			$description = $vars['entity']->description;
		//	$tags = $vars['entity']->tags;
		//	$access_id = $vars['entity']->access_id;
		} else  {
			$title = elgg_echo("logo:upload");
			$action = "logo/upload";
			$tags = "";
			$title = "";
			$description = "";
			if (defined('ACCESS_DEFAULT'))
				$access_id = ACCESS_DEFAULT;
			else
				$access_id = 0;
		}
	
?>
<div class="contentWrapper">
<form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" enctype="multipart/form-data" method="post">
<?php

	if ($action == "logo/upload") {

?>
		<p>
			<label><?php echo elgg_echo("logo:browser"); ?><br />
			<?php

				echo elgg_view("input/file",array('internalname' => 'upload'));
			
			?>
			</label>
		</p>
<?php

	}

?>
		<p>
			<label><?php echo elgg_echo("logo:upload:title"); ?><br />
			<?php

				echo elgg_view("input/text", array(
									"internalname" => "title",
									"value" => $title,
													));
			
			?>
			</label>
		</p>
		<p class="longtext_editarea">
			<label><?php echo elgg_echo("logo:upload:link"); ?><br />
			<?php

				echo elgg_view("input/text",array(
									"internalname" => "description",
									"value" => $description,
													));
			?>
			</label>
		</p>
	

		<p>
			<?php

				if (isset($vars['container_guid']))
					echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
				if (isset($vars['entity']))
					echo "<input type=\"hidden\" name=\"file_guid\" value=\"{$vars['entity']->getGUID()}\" />";
			
			?>
			<input type="submit" value="<?php echo "Upload"; ?>" />
		</p>

</form>
</div>