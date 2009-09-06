<?php
	/**
	* Edit number of wall post
	* 
	* Admin settings definition
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	$timeOfWallPost = $vars['entity']->timeOfWallPost;
	if(empty($timeOfWallPost)) $timeOfWallPost = 15;

	$countOfWallPost = $vars['entity']->countOfWallPost;
	if(empty($countOfWallPost)) $countOfWallPost = 20;
	
?>
<p>Max time of recently wall post: 
	<select name="params[timeOfWallPost]">
		<option value="1" <?php if ($timeOfWallPost == 1) echo " selected=\"yes\" ";  ?>>1</option>
		<option value="2" <?php if ($timeOfWallPost == 2) echo " selected=\"yes\" ";  ?>>2</option>
		<option value="3" <?php if ($timeOfWallPost == 3) echo " selected=\"yes\" ";  ?>>3</option>
		<option value="4" <?php if ($timeOfWallPost == 4) echo " selected=\"yes\" ";  ?>>4</option>
		<option value="5" <?php if ($timeOfWallPost == 5) echo " selected=\"yes\" ";  ?>>5</option>
		<option value="6" <?php if ($timeOfWallPost == 6) echo " selected=\"yes\" ";  ?>>6</option>
		<option value="7" <?php if ($timeOfWallPost == 7) echo " selected=\"yes\" ";  ?>>7</option>
		<option value="8" <?php if ($timeOfWallPost == 8) echo " selected=\"yes\" ";  ?>>8</option>
		<option value="9" <?php if ($timeOfWallPost == 9) echo " selected=\"yes\" ";  ?>>9</option>
		<option value="10" <?php if ($timeOfWallPost == 10) echo " selected=\"yes\" "; ?>>10</option>
		<option value="15" <?php if ($timeOfWallPost == 15) echo " selected=\"yes\" "; ?>>15</option>
		<option value="20" <?php if ($timeOfWallPost == 20) echo " selected=\"yes\" "; ?>>20</option>
		<option value="25" <?php if ($timeOfWallPost == 25) echo " selected=\"yes\" "; ?>>25</option>
		<option value="30" <?php if ($timeOfWallPost == 30) echo " selected=\"yes\" "; ?>>30</option>
		<option value="60" <?php if ($timeOfWallPost == 60) echo " selected=\"yes\" "; ?>>60</option>
		<option value="90" <?php if ($timeOfWallPost == 90) echo " selected=\"yes\" "; ?>>90</option>
		
	</select> days<br />
	
	Max number of recently wall post: 
	<select name="params[countOfWallPost]">
		<option value="10" <?php if ($countOfWallPost == 10) echo " selected=\"yes\" "; ?>>10</option>
		<option value="20" <?php if ($countOfWallPost == 20) echo " selected=\"yes\" "; ?>>20</option>
		<option value="30" <?php if ($countOfWallPost == 30) echo " selected=\"yes\" "; ?>>30</option>
		<option value="40" <?php if ($countOfWallPost == 40) echo " selected=\"yes\" "; ?>>40</option>
		<option value="50" <?php if ($countOfWallPost == 50) echo " selected=\"yes\" "; ?>>50</option>
		<option value="100" <?php if ($countOfWallPost == 100) echo " selected=\"yes\" "; ?>>50</option>
		<option value="150" <?php if ($countOfWallPost == 150) echo " selected=\"yes\" "; ?>>50</option>
		
	</select> wall posts
	
</p>
