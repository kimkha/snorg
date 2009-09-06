<?php

	/**
	* Notebook
	* 
	* All the Notebook JS can be found here
	* 
	* @package notebook
	* @author KimKha
	*/
	
?>

var notebookid = 0;

function openNotebook() {
	if ($("#notebook_wrapper").css('display') == 'none') {
		$(".wrapperWindow").hide();
		$("#notebook_wrapper").show();
	}
	else {
		$("#notebook_wrapper").hide();
	}
}

function loadNotebook() {
	$.getJSON("<?php echo $CONFIG->wwwroot;?>action/notebook/load", function(data) {
		$.each(data, function(name, value){
			insertNotebook(value);
		})
	})
	return true;
}

function insertNotebook(data) {
	var newnote = "";
	newnote += "<div class='notebookWrapper messageWindow' id='notebook-"+notebookid+"'>";
	newnote += "<div class='notebookTitle'>" + data.title + "</div>";
	newnote += "<div class='notebookDescription'>" + data.description + "</div>";
	newnote += "</div>";
	
	$("#recently_notebook .notebook_content").prepend(newnote);
	$("#recently_notebook .notebook_content").attr("scrollTop", 0);
	notebookid++;
	return true;
}

function buildNotebook() {
	var notebookdata = "";
	notebookdata += "<div id='notebook_data'>";
	
	notebookdata += "<div id='recently_notebook'>";
	notebookdata += "<div class='closeWindow' onclick='openNotebook();'></div>";
	notebookdata += "<div class='headerNotebook headerWindow'><?php echo elgg_echo("notebook:recently"); ?></div>";
	notebookdata += "<div class='notebook_content contentWindow'></div>"
	notebookdata += "</div>";
	
	notebookdata += "<div id='create_note'>";
	notebookdata += "<form>";
		notebookdata += "<div class='inputNotebook'>";
		notebookdata += "<label for='inputTitleNotebook'>Title:</label>";
		notebookdata += "<input name='title' type='text' id='inputTitleNotebook' autocomplete='off'></input>";
		notebookdata += "<input type='submit' name='submit' value='Save' id='btnSubmitNotebook' />";
		notebookdata += "</div>";
		
		notebookdata += "<div class='inputNotebook'>";
		notebookdata += "<label for='inputDescNotebook'>Description:</label><br />";
		notebookdata += "<textarea name='description' id='inputDescNotebook' class='notinymce'></textarea>";
		notebookdata += "</div>";
		
		notebookdata += "<div class='inputNotebook btnMore'>";
//		notebookdata += "<a id='btnNotebookMore' href='javascript:notebookmore();'>More</a>";
		notebookdata += "</div>";
		
		notebookdata += "<div id='create_note_more'>"
			notebookdata += "<div class='inputNotebook'>";
			notebookdata += "<label for='inputCatNotebook'>Category:</label>";
			notebookdata += "<input name='category' id='inputCatNotebook' autocomplete='off' />";
			notebookdata += "</div>";
			
			notebookdata += "<div class='inputNotebook'>";
			notebookdata += "<label for='inputCommNotebook'>Comments:</label><br />";
			notebookdata += "<textarea name='comment' id='inputCommNotebook' class='notinymce'></textarea>";
			notebookdata += "</div>";
		notebookdata += "</div>";
	notebookdata += "</form>";
	notebookdata += "</div>";
	
	notebookdata += "</div>";
	
	$("#notebook_wrapper").html(notebookdata);
	
	$("#create_note textarea").unbind("keypress");
	$("#create_note textarea").bind("keypress", function(){
		$(this).height($(this).attr("scrollHeight"));
	});
	
	$("#create_note form").unbind("submit");
	$("#create_note form").bind("submit", function(){
		var val = $(this).serializeArray();
		$.post("<?php echo $CONFIG->wwwroot; ?>action/notebook/create", val, function(data){
			insertNotebook(data);
			clearNotebookForm();
		}, "json");
		return false;
	});
}

function clearNotebookForm() {
	$("#create_note form").find("input[type='text']").val("");
	$("#create_note form").find("textarea").val("");
	$("#create_note form").find("textarea").height(13);
}

function notebookmore() {
	$("#create_note_more").toggle();
	var val = $("#btnNotebookMore").html();
	$("#btnNotebookMore").html((val=='Less')?'More':'Less');
}

$(document).ready(function(){
	buildNotebook();
	loadNotebook();
});

