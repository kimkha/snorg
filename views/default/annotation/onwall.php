<?php
	/**
	 * View comment on the wall
	 * 
	 * @author KimKha
	 */
	
	$comment = $vars['annotation'];
	$owner = get_user($comment->owner_guid);
	
?>
<div class="commentOnWall" id="commentOnWall_<?php echo $comment->id; ?>">

<div class="profile-icon">
	<?php
    	echo elgg_view("profile/icon", array(
							'entity' => $owner, 
							'size' => 'small')
		);
    		?>
</div>

<?php
	if ($comment->canEdit()) {
		$ajax = 'delete_element';
		$dellink = elgg_view("output/confirmlink",array(
				'href' => $vars['url'] . "action/comments/delete?annotation_id=" . $comment->id,
				'text' => elgg_echo('delete'),
				'confirm' => elgg_echo('deleteconfirm'),
				'ajax' => $ajax,
				'param' => "commentOnWall_".$comment->id,
		));
		echo "<div class='delete_note'>" . $dellink . "</div>";
	}
?>

<div class="content-wrap">
	<div class="title">
		<b><a href="<?php echo $owner->getURL(); ?>"><?php echo splitname($owner->name); ?></a></b>
		<span class="post-date"><?php echo friendly_time($vars['annotation']->time_created); ?></span>
	</div>
	
	<div class="content">
	<?php echo $comment->value; ?>
	</div>
	
	<div class="clearfloat"></div>
</div>

<div class="clearfloat"></div>
</div>