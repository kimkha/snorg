<?php
?>

	<script type="text/javascript" src="<?php echo $vars['url']; ?>vendors/jquery/jquery-ui-1.6.custom.min.js">
	</script>
	<script type="text/javascript" src="<?php echo $vars['url']; ?>javascript/JSSerializer.js">
	</script>
	
	<link type="text/css" href="<?php echo $vars['url']; ?>vendors/jquery/css/smoothness/ui.all.css" rel="stylesheet" >
	</link>
	 
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
                        //      var tokenName = friend.name;
                        //      foreach (filterTokens as ft){
                        //              if ()
                        //      }
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
	


