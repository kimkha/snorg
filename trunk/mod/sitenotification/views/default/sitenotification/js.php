<?php


?>
	function buildSitenotifcationDialog() {
		var dialog = "<div id='notification_data'>";
		dialog += "<div class='closeWindow' onclick='openSitenotifcationDialog();'></div>";
		dialog += "<div class='title headerWindow'><?php echo elgg_echo('sitenotification:title')?></div>";
		dialog += "<div id='notification_content' class='contentWindow'>";
		dialog += "<div class='loading'>Loading...</div>";
		dialog += "</div>";
		dialog += "</div>";
		
		$("#notification_wrapper").html(dialog);
		getAllNotification();
		
		$.timer(10000, function (timer) {
			$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetNewSitenotificationCount",function(msg){
				if (msg=='0'){
					$('#notification_taskbar .notification_name').html('Not');
				} else {
					$('#notification_taskbar .notification_name').html('['+msg+']');
					
					if ($("#notification_wrapper").css("display") == "block") {
						getUnreadNotification();
					}
				}
			});
		});
	}
	
	function openSitenotifcationDialog() {
		if ($("#notification_wrapper").css('display') == 'none') {
			$(".wrapperWindow").hide();
			$("#notification_wrapper").show();
		}
		else {
			$("#notification_wrapper").hide();
		}
		
	}
	
	function getAllNotification() {
		$("#notification_content").html("");
		getSitenotifcation("GetSitenotification");
	}
	function getUnreadNotification() {
		getSitenotifcation("GetUnreadSitenotification");
	}
	function getSitenotifcation(control) {
		$("#notification_content .loading").show();
		
		$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action="+control+"&user_guid=<?php echo get_loggedin_userid() ?>", function(notifications){
			var newNotification = "";
			$.each(notifications, function (name, value) {
				newNotification += viewSiteNotifcation(value);
			});
						
			$("#notification_content .loading").hide();
			$("#notification_content").prepend(newNotification);
			$('#notification_taskbar .notification_name').html('Not');
		});
	}
	
	function viewSiteNotifcation(data) {
		var html = "<div class='messageWindow'>";
		html += "<a href='" + data[1] + "'>" + data[0] + "</a> ";
		html += data[2] + " ";
		html += "<a href='" + data[4] + "'>" + data[3] + "</a> ";
		html += "</div>";
		return html;
	}
                
         
$(document).ready(function(){
	buildSitenotifcationDialog();
});
