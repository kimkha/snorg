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
	
	global $CONFIG;
	$sticked = get_entities_from_relationship(_STICK_BLOG_RELATIONSHIP_, 1);
	$sticked = parse_entities_by_subtype($sticked, "blog");
	
	// View first sticked blogspot
	echo elgg_view_entity($sticked[0]);
	
	unset($sticked[0]);
	$limit = 5;
	
	if (is_array($sticked) && count($sticked) > 0) {
?>
<div id="stick-blog-list">
	<div class="other-blog">Other post</div>
<?php
	
	// View list of older blogspot
	$n = 0;
	foreach ($sticked as $post) {
		$author = get_user((int) $post->getOwner());
		
?>
<div class="stick-blog-item">
	<div class="stick-blog-icon">
<?php
		echo elgg_view("profile/icon",array('entity' => $author, 'size' => 'tiny'));
?>
	</div>
	<div class="stick-blog-content">
		<div class="stick-blog-title"><a href="<?php echo $post->getURL(); ?>"><?php echo $post->title; ?></a></div>
		<div class="stick-blog-date">Posted <?php echo date("F j, Y", $post->getTimeCreated()); ?> by <a href="<?php echo $author->getURL(); ?>"><?php echo $author->name; ?></a></div>
	</div>
</div>
<?php
		$n++;
		if ($n >= 5) break;
	}
?>
</div>
<?php
		
	}

?>