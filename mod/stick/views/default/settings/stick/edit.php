<?php
	/**
	 * Elgg Stick
	 * 
	 * @author KimKha
	 * @package SNORG
	 */
	
	$blogcategory = $vars['entity']->blogcategory;
	if (empty($blogcategory)) $blogcategory="";
	
	echo "<strong>Category Homepage of Blog</strong>: <i>Example: Technical, Tourist, Company birthday</i>";
	echo elgg_view("input/text", array("internalname"=>"params[blogcategory]", "value"=>$blogcategory));
?>
