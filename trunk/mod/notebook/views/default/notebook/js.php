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
	$("#notebook_wrapper").toggle();
}

function reloadNotebook() {
	return true;
}

function insertNotebook(data) {
	var newnote = "";
	newnote += "<div class='contentWrapper' id='notebook-"+notebookid+"'>";
	newnote += "<div class='notebookTitle'>" + data.title + "</div>";
	newnote += "<div class='notebookDescription'>" + data.description + "</div>";
	newnote += "</div>";
	
	$("#recently_notebook .notebook_content").prepend(newnote);
	return true;
}

function buildNotebook() {
	var notebookdata = "";
	notebookdata += "<div id='notebook_data'>";
	
	notebookdata += "<div id='recently_notebook'>";
	notebookdata += "recently_notebook";
	notebookdata += "<div class='notebook_content'></div>"
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
		notebookdata += "<textarea name='description' id='inputDescNotebook'></textarea>";
		notebookdata += "</div>";
		
		notebookdata += "<div class='inputNotebook btnMore'>";
		notebookdata += "<a id='btnNotebookMore' href='javascript:notebookmore();'>More</a>";
		notebookdata += "</div>";
		
		notebookdata += "<div id='create_note_more'>"
			notebookdata += "<div class='inputNotebook'>";
			notebookdata += "<label for='inputCatNotebook'>Category:</label>";
			notebookdata += "<input name='category' id='inputCatNotebook' autocomplete='off'></input>";
			notebookdata += "</div>";
			
			notebookdata += "<div class='inputNotebook'>";
			notebookdata += "<label for='inputCommNotebook'>Comments:</label><br />";
			notebookdata += "<textarea name='comment' id='inputCommNotebook'></textarea>";
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
		$.getJSON("<?php echo $CONFIG->wwwroot;?>action/notebook/create", $(this).serializeArray(), function(data){
			insertNotebook(data);
		});
		return false;
	});
}

function notebookmore() {
	$("#create_note_more").toggle();
	var val = $("#btnNotebookMore").html();
	$("#btnNotebookMore").html((val=='Less')?'More':'Less');
}

$(document).ready(function(){
	buildNotebook();
});

