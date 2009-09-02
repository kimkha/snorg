<?php

	/**
	 * Ajax load pages
	 * 
	 * User don't need load fullpage to view
	 * 
	 * @package ElggFile
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @link http://elgg.org/
	 */
	
	
?>

	var ajaxloadHttp = /^(http|https):\/\/\S+$/i;
	var ajaxloadRoot = "<?php echo $CONFIG->wwwroot; ?>";
	var ajaxloadRe = /^(http|https):\/\/([^\/\s]+)\/(\S+)$/i;
	
	function ajaxload(link) {
		window.location.href = "#"+link;
		$("#layout_canvas").html($kloading());
		$("#layout_canvas").load(ajaxloadRoot + link + " #layout_canvas > *", function () {
			ajaxAllLinks();
		});
	}
	
	function ajaxloadP(input, link) {
		window.location.href = "#"+link;
		$("#layout_canvas").html($kloading());
		$("#layout_canvas").load(ajaxloadRoot + link + " #layout_canvas > *", input, function () {
			ajaxAllLinks();
		});
	}
	
	function ajaxAllLinks() {
		$("a").each(function() {
			$(this).click(function(){
				var link = $(this).attr('href');
				if (link.match(ajaxloadHttp)) {
					link = link.replace(ajaxloadRoot, "");
					ajaxload(link);
					return false;
				}
				return true;
			});
		});
		$("form").each(function(){
			$(this).submit(function(){
				var link = $(this).attr('action');
				if (typeof(link) == "undefined" || link == '') return false;
				
				if (link.match(ajaxloadHttp)) {
					link = link.replace(ajaxloadRoot, "");
					ajaxloadP($(this).serializeArray(), link);
					return false;
				}
				return false;
			});
		});/**/
	}
	
	
	$(document).ready(function(){
		ajaxAllLinks();
	});
