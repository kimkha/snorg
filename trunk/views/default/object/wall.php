<?php
	/**
	 * SNORG Wallpost view
	 * 
	 * @author KimKha
	 * @package SNORG
	 */

	$entity = $vars['entity'];
	if($vars['viewtype'] == 'wall'){
		$subtype = $entity->getSubtype();
		
		$title = (isset($vars['title']))?$vars['title']:$entity->title;
		$content = (isset($vars['content']))?$vars['content']:$entity->description;
		$dellink = (isset($vars['dellink']))?$vars['dellink']:'';
		$status = (isset($vars['status']))?$vars['status']:'';
		
		if ($dellink!=''){
			$dellink = elgg_view("output/confirmlink",array(
							'href' => $dellink,
							'text' => elgg_echo('delete'),
							'confirm' => elgg_echo('deleteconfirm'),
							'ajax' => 'delete_element',
							'param' => 'wall-singlepage-'.$entity->getGUID(),
			));
		}
		if ($status==''){
			$status = "<img src='" . $entity->getIcon('tiny') . "' alt='{$subtype}\'s icon' /> ". $subtype . " " . friendly_time($entity->time_created);
		}
		
		$user = $vars['entity']->getOwnerEntity();
		$username = $user->username;
		
?>
<div class="wall-singlepage" id="wall-singlepage-<?php echo $entity->getGUID(); ?>">
	<div class="wall-post">
	    <!-- the actual shout -->
		<div class="note_body">

	    <div class="wall_icon">
	    <?php
		        echo elgg_view("profile/icon",array('entity' => $user, 'size' => 'small'));
	    ?>
	    </div>
		<div class="wall_status">
			<div class="wall_options">
			
			<!--a href="<?php echo $vars['url']; ?>mod/thewire/add.php?wire_username=<?php echo $username; ?>" class="reply">reply</a-->
		<?php
/*		    //only have a reply option for main notes, not other replies
		    if($vars['entity']->parent == 0){
        ?>
		<a href="<?php echo $vars['url']; ?>mod/thewire/reply.php?note_id=<?php echo $vars['entity']->guid; ?>" class="reply">reply</a>
		<?php
	        }
*/
	    ?>
	    <div class="clearfloat"></div>
   		<?php
			if ($vars['entity']->canEdit()) {
				echo "<div class='delete_note'>" . $dellink . "</div>";
			}
		?>
	    </div>
	    
		
		<?php
		    echo "<b><a class='username' href='".$vars['url']."pg/profile/{$username}'>".splitname($user->name, 20)."</a> </b>";
		    
			echo parse_urls($title);
		?>
		</div>
		<?php
			if ($content != '') {
		?>
		<div class="wall_content_wrap">
			<div class="wall_content">
		<?php
				echo $content;
		?>
			</div>
		</div>
		<?php
			}
		?>
		<div class="clearfloat"></div>
		</div>
		<div class="note_date">
		
		<?php
			
				echo $status . ".";
			
		?>
		</div>
	</div>
	<div class="wall_comments" id="wall-comments-<?php echo $entity->getGUID(); ?>">
		<div id="wall_comment_<?php echo $entity->getGUID(); ?>">
		<?php
			$comments = $entity->getAnnotations('generic_comment');
			foreach ($comments as $c) {
				echo elgg_view_comment($c);
			}
		?>
		</div>
		<?php
			if (isloggedin() && $entity->comments_on != 'Off') {
		?>
		<div class="form_comment">
			<form action="<?php echo $vars['url']; ?>action/wall_comment?id=<?php echo $entity->getGUID(); ?>" onsubmit="return $ksimpleForm(this,'wall_comment_<?php echo $entity->getGUID(); ?>');">
			<textarea name="content"><?php echo elgg_echo("generic_comments:add"); ?></textarea>
			<input type='submit' value="<?php echo elgg_echo("generic_comments:text"); ?>" />
			</form>
			<div class="clearfloat"></div>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			setup_wallpost_textarea("wall-comments-<?php echo $entity->getGUID(); ?>", "<?php echo elgg_echo("generic_comments:add"); ?>");
		});
		</script>
		<?php
			}
		?>
	</div>
	<div class="clearfloat"></div>
</div>
<?php
	}
?>