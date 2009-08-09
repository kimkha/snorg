
<link type="text/css" href="<?php echo $vars['url']; ?>vendors/jquery/css/smoothness/jquery-ui-1.7.2.custom.css" rel="stylesheet">
</link>
<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/ui/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/ui/jquery-ui-1.7.2.custom.min.js">
</script>
<script type="text/javascript" src="<?php echo $vars['url']; ?>javascript/JSSerializer.js">
</script>


 
<div id="dialog" title="<?php echo elgg_echo('friends:widget:title') . " " . get_user($vars['entity']->owner_guid)->username ?>" class="collapsable_box_content" style="display:none;">
	<input id="inputFilter" type="text"/>
</div>

<script type="text/javascript">
	$(function(){
		
		
		$("#dialog").dialog({
			bgiframe: true,
			autoOpen: false,
			width: 400,
			height: 400,
			modal: true
		});
		
		var friends = null;
		$("#inputFilter").keypress(function(e){
			if (e.which == 13){
				var filteredFriends = filterFriends(friends, $("#inputFilter").val());
				displayFriendsOnDialog(filteredFriends);
			}
		});
		$("#btn_show_all").click(displayFriendDialog);
		
		function displayFriendDialog(){
		 $.ajax({
		   type: "POST",
		   url: "<?php echo $vars['url']; ?>query.php",
			data: "owner=<?php echo $vars['entity']->owner_guid ?>",
		   success: function(msg){
		     
		     var serializer = new JSSerializer(); 
		     friends = serializer.deserialize(msg);
		     //alert(friends[2].usericon + friends[0].userlink);
		     //$("#dialog").dialog();
		     $('#dialog').dialog("open");
		     displayFriendsOnDialog(friends);
		     $('#dialog').css('display', 'block');
		   }
		 });
		
		}
	
 		function displayFriendsOnDialog(friends){
				
			$("#dialog > div").remove();				
			for(index in friends){
				$('#dialog').append("<div class='contentWrapper'> <a href=\"" + friends[index].userurl + "\"><img src=\"" + friends[index].usericon +" /> <b>" + friends[index].username + " </b> </a> </div>");				
			}
			
		}

	
		function filterFriends(friends,strFilter){
			var filteredFriends = new Array() ;
			
			//Search by full name
			
			//Split filter tokens
			//var filterTokens = $strFilter.split();
			
			
			//loop all friends
			//foreach (friends as friend){
			//	var tokenName = friend.name;
			//	foreach (filterTokens as ft){
			//		if ()
			//	}
			//}
			//if each
			
			//Search by username
			var count = 0;
			for (index in friends){
				var pos = friends[index].username.toLowerCase().indexOf(strFilter.toLowerCase());
				if ( pos >=0 ){
					filteredFriends[count++] = friends[index];	
				}
				 
			}
			return filteredFriends;
			
		}
	
			
	});

	

	
</script>

<?php

    /**
	 * Elgg Friends
	 * Friend widget options
	 * 
	 * @package ElggFriends
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */
	

    //the page owner
	$owner = get_user($vars['entity']->owner_guid);

    //the number of files to display
	$num = (int) $vars['entity']->num_display;
	if (!$num)
		$num = 8;
		
	//get the correct size
	$size = (int) $vars['entity']->icon_size;
	if (!$size || $size == 1){
		$size_value = "small";
	}else{
    	$size_value = "tiny";
	}
		
    // Get the users friends
	$friends = $owner->getFriends("", $num, $offset = 0);
		
	// If there are any $friend to view, view them
	if (is_array($friends) && sizeof($friends) > 0) {

		echo "<div id=\"widget_friends_list\">";
		echo "<a id='btn_show_all' href='javascript:void(0);' >".elgg_echo('friends:widget:showall')."</a>";

		foreach($friends as $friend) {
			echo "<div class=\"widget_friends_singlefriend\" >";
			echo elgg_view("profile/icon",array('entity' => get_user($friend->guid), 'size' => $size_value));
			echo "</div>";
		}

		echo "</div>";
			
    }
	
?>