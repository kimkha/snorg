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
	
	$catId = get_input("catId", 0);
	wallpost(get_loggedin_userid(), "kimkha is pro", "it's truth", 'short');
	page_draw("dkdkdkd", "djdjdjd".$catId);
	
?>