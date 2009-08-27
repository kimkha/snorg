<?php


?>

function viewFriendsBox(action, ownerId) {
	var title;
	var content;
	var wrapper;
	
	title='kimkha friends';
	content = "<input id='inputFilter' type='text'/>";
	content += "<div id =\"friends_wrapper\" style=\"max-height: 300px; overflow-y:auto;\"> </div>";
	wrapper = $kbox(title, content);
	
	var friends = null;
	
	$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=" + action + "&owner="+ownerId, function (result) {
		friends = result;
		displayFriendsOnDialog(friends);
	});
	
	$("#inputFilter").keypress(function(e){
		if (e.which == 13){
			var filteredFriends = filterFriends(friends, $("#inputFilter").val());
			displayFriendsOnDialog(filteredFriends);
		}
    });
	
}

function displayFriendsOnDialog(friends) {
	var list = ''
	for(index in friends){
		list += "<div class='contentWrapper'>";
		list += "<a href='" + friends[index][1] + "'>";
		list += "<img src='" + friends[index][2] + "' alt='Avatar of " + friends[index][0] + "' /><b>" + friends[index][0] + "</b>";
		list += "</a></div>";                                
	}
	$('#friends_wrapper').html(list);
}

function filterFriends(friends,strFilter){
	var filteredFriends = new Array() ;
	
	//Search by username
	var count = 0;
    for (index in friends) {
    	var pos = friends[index][0].toLowerCase().indexOf(strFilter.toLowerCase());
		if ( pos >=0 ){
			filteredFriends[count++] = friends[index];      
		}
    }
    return filteredFriends;
}


