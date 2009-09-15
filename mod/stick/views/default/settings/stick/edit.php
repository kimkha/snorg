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
	
	$blogcategory = $vars['entity']->blogcategory;
	if (empty($blogcategory)) $blogcategory="";
	
	echo "<strong>Category Homepage of Blog</strong>: <i>Example: Technical, Tourist, Company birthday</i>";
	echo elgg_view("input/text", array("internalname"=>"params[blogcategory]", "value"=>$blogcategory));
?>
