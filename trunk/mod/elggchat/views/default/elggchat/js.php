<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* All the javascript/JQuery functions are in this file
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/
	//require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
	global $CONFIG;
	$basesec = get_plugin_setting("chatUpdateInterval","elggchat");
	if(!$basesec) $basesec = 5;
	$maxsecs = get_plugin_setting("maxChatUpdateInterval","elggchat");
	if(!$maxsecs) $maxsecs = 30;
?>

	var basesec = <?php echo $basesec;?>;
	var maxsecs = <?php echo $maxsecs;?>;
	var delay = 1000;
	
	var secs;
	var processing = false;
	var pollingPause = false;
	
	var lastTimeDataReceived = new Date().getTime();
	
	function InitializeTimer(){
		// Set the length of the timer, in seconds
		secs = basesec;
		tick();
	}

	function tick(){
		if(!pollingPause){
			if(!processing){
				if (secs == 0){
					checkForSessions();					
				} else {
					secs = secs - 1;
				}
			} else {
				resetTimer();
			}
			
			self.setTimeout("tick()", delay);
		}
	}
	
	function resetTimer(){
		// if needed apply multiplier
		var currentTimeStamp = new Date().getTime();
		var timeDiff = (currentTimeStamp - lastTimeDataReceived) / 1000;
		
		var interval = Math.ceil((Math.sqrt(Math.pow(basesec * 10 / 2, 2) + (2 * basesec * 10 * timeDiff)) - (basesec * 10 / 2)) / (basesec * 10));
		// reset secs
		secs = basesec * interval;
		if(secs > maxsecs){
			secs = maxsecs;
		}
	}
		
	function inviteFriends(sessionid){
		var currentChatWindow = $("#chatwindow" + sessionid + " .chatmembersfunctions_invite"); 
		if(currentChatWindow.css("display") != "block"){
			currentChatWindow.html("");
			$("#elggchat_friends_picker .chatmemberinfo").each(function(){
				var friend = $(this).find("a");
				if(!($("#chatwindow" + sessionid + " .chatmember a[rel='" + friend.attr('rel') + "']").length > 0)){
					newFriend = "<a href='javascript:addFriend(" + sessionid + ", " + friend.attr('rel') + ")'>";
					newFriend += friend.html();
					newFriend += "</a><br />";
					currentChatWindow.append(newFriend);
				}
			});
		}
		currentChatWindow.slideToggle();
	}
	
	function addFriend(sessionid, friend){
		$.post("<?php echo $CONFIG->wwwroot; ?>action/elggchat/invite?chatsession=" + sessionid + "&friend=" + friend, function(){
			$("#chatwindow" + sessionid + " .chatmembersfunctions_invite").toggle();
			checkForSessions();
			$("#chatwindow" + sessionid + " input[name='chatmessage']").focus();
		});
	}	
	
	function leaveSession(sessionid){
		if(confirm("<?php echo elgg_echo('elggchat:chat:leave:confirm');?>")){
			eraseCookie("elggchat_session_" + sessionid);
			var current = readCookie("elggchat");
			if(current == sessionid){
				eraseCookie("elggchat");
			}
			$.post("<?php echo $CONFIG->wwwroot; ?>action/elggchat/leave?chatsession=" + sessionid, function(){
				$("#chatwindow" + sessionid).remove();
				checkForSessions();
			});
		} 
	}
	
	function elggchat_toolbar_resize(){
		$("#elggchat_toolbar_left").css("width", $(window).width() - $("#toggle_elggchat_toolbar").width()- $("#notification_taskbar").width() - 70);

	}
	
/*	function toggleChatToolbar(speed){
		$('#elggchat_toolbar_left').toggle(speed);
		$('#toggle_elggchat_toolbar').toggleClass('minimizedToolbar');
		
		if($('#toggle_elggchat_toolbar').hasClass('minimizedToolbar')){
			createCookie("elggchat_toolbar_minimized", "true");
			pollingPause = true;
			$('#toggle_elggchat_toolbar').attr("title", "<?php echo elgg_echo("elggchat:toolbar:maximize");?>");
		} else {
			pollingPause = false;
			checkForSessions();
			tick();
			eraseCookie("elggchat_toolbar_minimized");
			$('#toggle_elggchat_toolbar').attr("title", "<?php echo elgg_echo("elggchat:toolbar:minimize");?>");
		}
	}*/
	
	function startSession(friendGUID){
		$.post('<?php echo $CONFIG->wwwroot;?>action/elggchat/create?invite=' + friendGUID, function(data){
			if(data){
				checkForSessions();
				if ($("#chatwindow" + data + " .chatsessiondatacontainer").css("display") != "none") {
					$("#chatwindow" + data + " .chatsessiondatacontainer").css("display", "none");
				}
				openSession(data);
			}
		});
	}
	
	function toggleFriendsPicker(){
		$("#elggchat_friends_picker").slideToggle();
	}
	
	function scroll_to_bottom(sessionid){
		var chat_window = $("#chatwindow" + sessionid +" .chatsessiondata");
		var scrHeight = chat_window.find(".chatmessages").attr("scrollHeight");
		chat_window.find(".chatmessages").attr("scrollTop", scrHeight);
	}
	
	function checkForSessions(){
		// Starting the work, so stop the timer
		processing = true;
		
		$.getJSON("<?php echo $CONFIG->wwwroot; ?>action/elggchat/poll", function(data){
			if(typeof(data.sessions) != "undefined"){
				var current = readCookie("elggchat");
				
				$.each(data.sessions, function(i, session){
					var sessionExists = false;
					$("#chatwindow" + i).each(function(){
						sessionExists = true;
					});
					if(i != current || sessionExists == false){
						
						var newSession = "";
						
						newSession += "<div class='elggchat_session_leave' onclick='leaveSession(" + i + ")' title='<?php echo elgg_echo("elggchat:chat:leave");?>'></div><div class='elggchat_session_mini' onclick='javascript:openSession(" + i + ")+ session.name;' title='<?php echo elgg_echo("elggchat:chat:minimize");?>'></div><a href='javascript:openSession(" + i + ")'>" + session.name + "</a>";
						newSession += "<div class='chatsessiondatacontainer'>";
						newSession += "<div class='chatsessiondata'>"; 
						newSession += "<div class='chatmembers'><table>";
						
							if(typeof(session.members) != "undefined"){
								$.each(session.members, function(memNum, member){
									newSession += member;
								});
							}

							newSession += "</table></div>";
							newSession += "<div class='chatmembersfunctions'><a href='javascript:inviteFriends(" + i + ")'><?php echo strtolower(elgg_echo("elggchat:chat:invite")); ?></a>";
														
							newSession += "</div><div class='chatmembersfunctions_invite'></div>";
							
							newSession += "<div class='chatmessages'>";
							if(typeof(session.messages) != "undefined"){
								$.each(session.messages, function(msgNum, msg){
									newSession += msg;
								});
							}
							newSession += "</div>";
							newSession += "<div class='elggchatinput'>";
							newSession += "<form>";
							newSession += "<input name='chatsession' type='hidden' value='" + i + "'></input>";	
							newSession += "<input name='chatmessage' type='text' autocomplete='off'></input>";						
							newSession += "</form>";
							newSession += "</div>";
						newSession += "</div>";	
						newSession += "</div>";
						if(sessionExists){
							 $("#chatwindow" + i).html(newSession);
						} else {
							newSession = "<div class='session' id='chatwindow" + i + "'>" + newSession + "</div>";
							$("#elggchat_sessions").append(newSession);
						}
					} else {
						if ($("#chatwindow" + i + ">a").html() != session.name) $("#chatwindow" + i + ">a").html(session.name);
						var membersData = "";
						if(typeof(session.members) != "undefined"){
							$.each(session.members, function(memNum, member){
								membersData += member;
							});
						}
						$("#chatwindow" + i + " .chatmembers").html("<table>" + membersData + "</table>");
						
						var messageData = "";
						var cookie = readCookie("elggchat_session_" + i);
						
						var lastKnownMsgId = 0;
						if(cookie > 0){
							var lastKnownMsgId = parseInt(readCookie("elggchat_session_" + i));
						} 
						
						if(typeof(session.messages) != "undefined"){
							$.each(session.messages, function(msgNum, msg){
								if(msgNum > lastKnownMsgId || lastKnownMsgId == NaN){
									messageData += msg;
									lastTimeDataReceived = new Date().getTime();
								}
							});
						}
						$("#chatwindow" + i + " .chatmessages").append(messageData);						
					}
				});
				
				// search for new data
				$(".session").each(function(){
				
					var sessionid = $(this).attr("id");
					var lastKnownMsgId = parseInt(readCookie("elggchat_session_" + sessionid));
					var newestMsgId = parseInt($("#chatwindow" + sessionid + " .chatmessages div:last").attr("id"));
					
					if(newestMsgId > lastKnownMsgId || !lastKnownMsgId){
						if($(this).find(".chatsessiondatacontainer").css("display") != "block" && newestMsgId){
							$("#chatwindow" + sessionid).addClass("elggchat_session_new_messages");
							lastTimeDataReceived = new Date().getTime();
						}
					}
				
				});
				
				// register submit events on message input
				$(".elggchatinput form").unbind("submit");
				$(".elggchatinput form").bind("submit", function(){
					var input = $.trim($(this).find("input[name='chatmessage']").val());
					
					if(input != ""){
						$.post("<?php echo $CONFIG->wwwroot;?>action/elggchat/post_message", $(this).serialize(), function(data){
							checkForSessions();
						});
					}
					// empty input field
					$(this).find("input[name='chatmessage']").val("");
					
					return false;
				});
				
				if(current){
					if($("#chatwindow" + current + " .chatsessiondatacontainer").css("display") != "block"){
						openSession(current);
					}
					var cookie = readCookie("elggchat_session_" + current);
					if(cookie > 0){
						var lastKnownMsgId = parseInt(cookie);
					} else {
						var lastKnownMsgId = 0;
					}
					var newestMsgId = parseInt($("#chatwindow" + current + " .chatmessages div:last").attr("id"));
					if(newestMsgId > lastKnownMsgId){
						scroll_to_bottom(current);
						createCookie("elggchat_session_" + current, newestMsgId);
					}
				}
				
			}
			
			// build friendspicker
			$("#elggchat_friends a").html("<?php echo elgg_echo("elggchat:friendspicker:info");?>(" + data.friends_online_count + ")");
			if(typeof(data.friends) != "undefined"){
				$("#elggchat_friends_picker").html("");
				
				var tableData = "";
				$.each(data.friends, function(i, friend){
					tableData += friend;
					
				});
				$("#elggchat_friends_picker").append("<table>"  + tableData + "</table>");
				
				$("#elggchat_friends_picker a").each(function(){
					$(this).attr("href","javascript:startSession(" + this.rel + "); toggleFriendsPicker();");
				});
			}
			
			// Done with all the work
			resetTimer();
			processing = false;
		});
	}
	
	function openSession(id){
		$("#chatwindow"+ id).removeClass("elggchat_session_new_messages");
		var current = $("#chatwindow" + id + " .chatsessiondatacontainer").css("display");
		eraseCookie("elggchat");
		$("#elggchat_sessions .chatsessiondatacontainer").hide();
		if(current != "block"){
			createCookie("elggchat", id);
			var last = $("#chatwindow" + id + " .chatmessages div:last").attr("id");
			createCookie("elggchat_session_" + id, last); 
			$("#chatwindow" + id + " .chatsessiondatacontainer").toggle();
		}	
		scroll_to_bottom(id);
		$("#chatwindow" + id + " input[name='chatmessage']").focus();
	}
	
	/* Cookie Functions */
	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "Expires=" + date.toGMTString() + "; ";
		} else {
			var expires = "";
		}
		
		document.cookie = name + "=" + value + "; " + expires + "Path=/;";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');

		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];

			while (c.charAt(0) == ' '){
				c = c.substring(1, c.length);
			}
			
			if (c.indexOf(nameEQ) == 0){
				return c.substring(nameEQ.length, c.length);
			}
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}	
	
	$(document).ready(function(){
		if(readCookie("elggchat_toolbar_minimized")){
			toggleChatToolbar(0);
		}
		
		$(window).resize(function(){
			elggchat_toolbar_resize();
		});
		elggchat_toolbar_resize();
		InitializeTimer();
		checkForSessions();
	});
	