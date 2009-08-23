<?php

	/**
	* Notebook
	* 
	* All the Notebook CSS can be found here
	* 
	* @package notebook
	* @author KimKha
	*/
	
?>

#notebook_wrapper {
	display: none;
}

#notebook_data {
	border: 1px solid #4690D6;
	border-bottom: 0px;
	background: #E4ECF5;
	
	-moz-border-radius-topright:5px; 
	-moz-border-radius-topleft:5px; 
	-webkit-border-top-left-radius:5px;
	-webkit-border-top-right-radius:5px;
	margin: 0 -4px;
	position:absolute;
	bottom:27px;
	width:236px;
	overflow:hidden;
}

#create_note {
	font-size: 10px;
	font-weight: normal;
	background-color: #FFFFFF;
	padding: 4px 0px;
}

#create_note .inputNotebook {
	vertical-align: text-top;
	padding: 1px 0px;
}

#create_note_more {
	display: none;
}

#create_note label {
	font-weight: normal;
	font-size: 10px;
}

#create_note input,
#create_note textarea {
	border-color: #969696;
	font-size:10px;
	padding: 2px;
	margin: 0px 5px;
	width: 140px;
	-webkit-border-radius: 0px; 
	-moz-border-radius: 0px;
}

#create_note input:focus,
#create_note textarea:focus {
	background-color: #FFFFFF;
}

#create_note textarea {
	width: 220px;
	height: 13px;
	overflow: hidden;
}

#btnSubmitNotebook {
	width: 40px !important;
	height:17px !important;
	line-height: normal !important;
	text-align: center;
	border: none !important;
}
#btnSubmitNotebook:focus {
	background-color: #4690D6 !important;
}

#create_note .btnMore {
	text-align: right;
	font-size: 9px;
	margin-right: 10px;
	padding: 0px;
}
