<?php


?>
	function buildSitenotifcationDialog() {
		var dialog = "<div id='notification_data'>";
		dialog += "<div class='closeWindow' onclick='openSitenotifcationDialog();'></div>";
		dialog += "<div class='title headerWindow'><?php echo elgg_echo('sitenotification:title')?></div>";
		dialog += "<div class='showall'><a href='<?php echo $CONFIG->wwwroot ?>pg/sitenotification'>Show all</a></div>";
		dialog += "<div class='clearfloat'></div>";
		
		dialog += "<div id='notification_content' class='contentWindow'>";
		dialog += "</div>";
		dialog += "</div>";
		
		$("#notification_wrapper").html(dialog);
		getAllNotification();
		
		$.timer(5000, function (timer) {
			$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action=GetNewSitenotificationCount&user_guid=<?php echo get_loggedin_userid(); ?>",function(data){
				if (typeof(data) == "undefined") return false;
				msg = data.count;
				
				if (msg!=0){
					$('#notification_taskbar .notification_name').html('['+msg+']');
					if ($("#notification_wrapper").css("display") == 'block') {
						getUnreadNotification();
					}
				}
			});
		});
	}
	
	function openSitenotifcationDialog() {
		if ($("#notification_wrapper").css('display') == 'none') {
			getUnreadNotification();
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
		$("#notification_load").prepend($kloading());
		
		$.getJSON("<?php echo $CONFIG->wwwroot; ?>query.php?action="+control+"&user_guid=<?php echo get_loggedin_userid(); ?>", function(notifications){
			
			if (typeof(notifications) != "undefined") {
				var newNotification = "";
				$.each(notifications, function (name, value) {
					newNotification += viewSiteNotifcation(value);
				});
				
				$("#notification_content").prepend(newNotification);
				newNotification = "";
			}
			
			$("#notification_load .ajax_loader").remove();
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
