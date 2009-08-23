<?php


?>
	function buildSitenotifcationDialog() {
		var dialog = "<div id='notification_data'>";
		dialog += "<div class='title'><?php echo elgg_echo('sitenotification:title')?></div>"
		dialog += "<div class='loading'>Loading...</div>"
		dialog += "</div>";
		
		$("#notification_wrapper").html(dialog);
		
		$.timer(10000, function (timer) {
			$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetNewSitenotificationCount",function(msg){
				if (msg=='0'){
					$('#notification_taskbar .notification_name').html('Not');
				} else {
					$('#notification_taskbar .notification_name').html('['+msg+']');
				}
								
			});
		});
	}
	
	function openSitenotifcationDialog() {
		$("#notification_wrapper").toggle();
		$("#notification_data .loading").show();
		
		$('#notification_taskbar .notification_name').html('Not');
		$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetSitenotification&user_guid=<?php echo get_loggedin_userid() ?>", function(notifications){
			var newNotification = "";
			$.each(notifications, function (name, value) {
				newNotification += viewSiteNotifcation(value);
			});
						
			$("#notification_data .loading").hide();
			$("#notification_data .loading").before(newNotification);
		});
	}
	
	function viewSiteNotifcation(data) {
		var html = "<div class='contentWrapper'>";
		html += "<a href='" + data[1] + "'>" + data[0] + "</a> ";
		html += data[2];
		html += "<a href='" + data[4] + "'>" + data[3] + "</a> ";
		html += "</div>";
		return html;
	}
                
         
$(document).ready(function(){
	buildSitenotifcationDialog();
});
