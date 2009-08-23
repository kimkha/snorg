<?php


?>
        $(function(){
                
                
                $("#sitenotificationDialog").dialog({
                        bgiframe: true,
                        autoOpen: false,
                        width: 250,
                        height: 300,
                        position: ['right','bottom'],
                        resizable: false,
                        draggable: false
                });
                
                
                
                $("#sitenotification_bottombar").click(displaySitenotifcationDialog);
                
                 
				$.timer(10000, function (timer) {
				  		$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetNewSitenotificationCount",function(msg){
								if (msg=='0'){
									$('#sitenotification_bottombar').html('Not');
								} else {
									$('#sitenotification_bottombar').html('['+msg+']');
								}
								
							});
						});
		  		
				  		
				  

                
                function displaySitenotifcationDialog(){
                	$('#sitenotification_bottombar').html('Not');
                	$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetSitenotification&user_guid=<?php echo get_loggedin_userid() ?>", function(notifications){
                     
                     //alert(friends[2].usericon + friends[0].userlink);
                     //$("#dialog").dialog();
                     $('#sitenotificationDialog').dialog("open");
                     displayNotificationOnDialog(notifications);
                     $('#sitenotificationDialog').css('display', 'block');
                   });
                
                }
        
                function displayNotificationOnDialog(notifications){
                                
                        $("#sitenotificationDialog > div").remove();                            
                        for(index in notifications){
                        		                        	
                                $('#sitenotificationDialog').append(
								"<div class=\"contentWrapper\">" +
								"<a href=\"" + notifications[index][1] + "\">" +
								notifications[index][0] + "</a>" +
								' ' + notifications[index][2] + 
								"<a href=\"" + notifications[index][4] + "\">" +
								' ' + notifications[index][3] + '</a>' + 
								"</div>" 
								);                            
                        }
                        
                }

        
        
                        
        });
