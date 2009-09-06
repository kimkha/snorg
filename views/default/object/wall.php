<?php
	/**
	 * Elgg default object view.
	 * This is a placeholder.
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
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
			));
		}
		if ($status==''){
			$status = "<img src='" . $entity->getIcon('tiny') . "' alt='{$subtype}\'s icon' /> ". $subtype . " " . friendly_time($entity->time_created);
		}
		
		$user = $vars['entity']->getOwnerEntity();
		$username = $user->username;
		
?>
<div class="wall-singlepage">
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
		    echo "<b><a class='username' href='".$vars['url']."pg/profile/{$username}'>".splitname($user->name)."</a> </b>";
		    
			echo parse_urls($title);
		?>
		</div>
		<div class="wall_content">
		<?php
			echo $content;
		?>
		</div>
		<div class="clearfloat"></div>
		</div>
		<div class="note_date">
		
		<?php
			
				echo $status . ".";
			
		?>
		</div>
	</div>
	<div class="wall_comments">
		<div id="wall_comments_<?php echo $entity->getGUID(); ?>">
		</div>
		
		<form action="<?php echo $vars['url']; ?>action/wall_comment?id=<?php echo $entity->getGUID(); ?>" onsubmit="return $ksimpleForm(this,'wall_comments_<?php echo $entity->getGUID(); ?>');">
		<textarea name="content"></textarea><br />
		<input type='submit' value="Comment" />
		</form>
	</div>
	<div class="clearfloat"></div>
</div>
<?php
	}
?>