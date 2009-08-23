<?php
?>
<div id="dialog"  class="collapsable_box_content" style="display:none;">
	        <input id="inputFilter" type="text"/>
	        <div id = "friends_wrapper" style="max-height: 300px; overflow-y:auto;"> </div>
	</div>
	
<script type="text/javascript">


        $(function(){
                
                
                $("#dialog").dialog({
                        bgiframe: true,
                        autoOpen: false,
                        width: 400,
                        height: 400,
                        modal: true,
                        
                });
                
                var friends = null;
                $("#inputFilter").keypress(function(e){
                        if (e.which == 13){
                                var filteredFriends = filterFriends(friends, $("#inputFilter").val());
                                displayFriendsOnDialog(filteredFriends);
                        }
                });
                
                $("#btn_show_all").click(displayFriendDialog);
                $("#btn_mf_show_all").click(displayFriendDialog);
                $("#btn_pymk_show_all").click(displayFriendDialog);
                
                function displayFriendDialog(){
                	
                	action='';
                	
                	if (this.id=='btn_show_all')
					{
						
						action = "GetFriends&owner=<?php echo $vars['entity']->owner_guid ?>";
                 	} else if (this.id == 'btn_mf_show_all'){
                 		
                 		action = "GetMutualFriends";
                 	} else if (this.id == 'btn_pymk_show_all'){
                 		
                 		action = "GetPeopleYouMayKnow";
                 	}
                 
                 	 $.getJSON("<?php echo $vars['url']; ?>query.php?action=" + action,fnSuccess);
                 }
                
                fnSuccess = function(result){
                     
                     friends = result;
                     //alert(friends[2].usericon + friends[0].userlink);
                     //$("#dialog").dialog();
                     $('#dialog').dialog("open");
                     displayFriendsOnDialog(friends);
                     $('#dialog').css('display', 'block');
                }
        
                function displayFriendsOnDialog(friends){
                                
                        $("#dialog > div > div").remove();                            
                        for(index in friends){
                        		                        	
                                $('#friends_wrapper').append("<div class='contentWrapper'> <a href=\"" + friends[index][1] + "\"><img src=\"" + friends[index][2] + "\" /> <b>" + friends[index][0] + " </b> </a> </div>");                                
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
                                var pos = friends[index][0].toLowerCase().indexOf(strFilter.toLowerCase());
                                if ( pos >=0 ){
                                        filteredFriends[count++] = friends[index];      
                                }
                                 
                        }
                        return filteredFriends;
                        
                }
        
                        
        });
</script>
	


