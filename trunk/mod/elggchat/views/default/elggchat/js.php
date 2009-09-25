<?php
	
	/**
	 * Edit to make chat intelligently
	 * 
	 * @author KimKha
	 * @package Snorg
	 */
	
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
	
	var chatsessionTimestamp = 0;
	
	var leftHide = 0;
	var rightHide = 0;
	var maxVisibleWindow = 6;
	
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
			var canInvite = false;
			$("#elggchat_friends_picker .chatmemberinfo").each(function(){
				var friend = $(this).find("a");
				if(!($("#chatwindow" + sessionid + " .chatmember a[rel='" + friend.attr('rel') + "']").length > 0)){
					newFriend = "<a href='javascript:addFriend(" + sessionid + ", " + friend.attr('rel') + ")'>";
					newFriend += friend.html();
					newFriend += "</a><br />";
					currentChatWindow.append(newFriend);
					canInvite = true;
				}
			});
			if (!canInvite) currentChatWindow.html("<i><?php echo elgg_echo('elggchat:chat:caninvite'); ?></i>");
		}
		currentChatWindow.slideToggle();
		
		currentChatWindow.blur(function(){
			$(this).slideToggle();
		});
	}
	
	function addFriend(sessionid, friend){
		$.post("<?php echo $CONFIG->wwwroot; ?>action/elggchat/invite?chatsession=" + sessionid + "&friend=" + friend, function(){
			$("#chatwindow" + sessionid + " .chatmembersfunctions_invite").toggle();
			checkForSessions();
			$("#chatwindow" + sessionid + " input[name='chatmessage']").focus();
		});
	}	
	
	function leaveSession(sessionid){
		$kconfirm("<?php echo elgg_echo('elggchat:chat:leave:confirm');?>", function(ans){
			if (!ans) return false;
			eraseCookie("elggchat_session_" + sessionid);
			var current = readCookie("elggchat");
			if(current == sessionid){
				eraseCookie("elggchat");
			}
			$.post("<?php echo $CONFIG->wwwroot; ?>action/elggchat/leave?chatsession=" + sessionid, function(){
				$("#chatwindow" + sessionid).remove();
				checkForSessions();
				floatChatWindow(0);
			});
		});
	}
	
	function elggchat_toolbar_resize(){
		var w = $(window).width() - $("#toggle_elggchat_toolbar").width()- $("#leftside_taskbar").width() - 62;
		$("#elggchat_toolbar_left").css("width", w);
		w = w - 165;
		maxVisibleWindow = Math.floor(w/130);
	}
	
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
		
		$.getJSON("<?php echo $CONFIG->wwwroot; ?>action/elggchat/poll?currentTimestamp="+chatsessionTimestamp, function(data){
			if (typeof(data.timestamp) != "undefined" && data.timestamp != '')
				chatsessionTimestamp = data.timestamp;
			
			if(typeof(data.sessions) != "undefined"){
				var current = readCookie("elggchat");
				
				$.each(data.sessions, function(i, session){
					session.name = splitname(session.name, 20);
					
					var sessionExists = false;
					$("#chatwindow" + i).each(function(){
						sessionExists = true;
					});
					if(!sessionExists){
						
						var newSession = "";
						
						newSession += "<div class='elggchat_session_leave' onclick='leaveSession(" + i + ")' title='<?php echo elgg_echo("elggchat:chat:leave");?>'></div><div class='elggchat_session_mini' onclick='javascript:openSession(" + i + ");' title='<?php echo elgg_echo("elggchat:chat:minimize");?>'></div><a class='elggchat_session_name' href='javascript:openSession(" + i + ");'>" + session.name + "</a>";
						newSession += "<div class='chatsessiondatacontainer'>";
						newSession += "<div class='chatsessiondata'>"; 
						newSession += "<div class='chatmembers'><table>";
						
							if(typeof(session.members) != "undefined"){
								$.each(session.members, function(memNum, member){
									newSession += member;
								});
							}

							newSession += "</table></div>";
							newSession += "<div class='chatmembersfunctions'><a href='javascript:inviteFriends(" + i + ");'><?php echo strtolower(elgg_echo("elggchat:chat:invite")); ?></a>";
														
							newSession += "</div><div class='chatmembersfunctions_invite'></div>";
							
							newSession += "<div class='chatmessages'>";
							newSession += "</div>";
							newSession += "<div class='elggchatinput'>";
							newSession += "<form>";
							newSession += "<input name='chatsession' type='hidden' value='" + i + "'></input>";	
							newSession += "<textarea name='chatmessage' type='text'></textarea>";						
							newSession += "</form>";
							newSession += "</div>";
						newSession += "</div>";	
						newSession += "</div>";
							newSession = "<div class='session' id='chatwindow" + i + "'>" + newSession + "</div>";
							$("#elggchat_sessions").append(newSession);
							
							var notRead = readCookie("chat_lastsessionId_"+i);
							var lastId = parseInt(notRead);
							if(typeof(session.messages) != "undefined"){
								$.each(session.messages, function(msgNum, msg){
									insertMessage(i, msg);
									lastId = msg.guid;
								});
							}
							
							if (notRead == "" || parseInt(notRead) < lastId) {
								$("#chatwindow" + i).addClass("elggchat_session_new_messages");
							}
							else {
								createCookie("chat_lastsessionId_"+i, lastId);
							}
							
							autoHideChatWindow();
							openSession(i);
					} else {
						if ($("#chatwindow" + i + ">a").html() != session.name) $("#chatwindow" + i + ">a").html(session.name);
						var membersData = "";
						if(typeof(session.members) != "undefined"){
							$.each(session.members, function(memNum, member){
								membersData += member;
							});
						}
						$("#chatwindow" + i + " .chatmembers").html("<table>" + membersData + "</table>");
						
						var isnewMsg = false;
						var messageData = "";
						var lastId = 0;
						if(typeof(session.messages) != "undefined"){
							$.each(session.messages, function(msgNum, msg){
								insertMessage(i, msg);
								lastTimeDataReceived = new Date().getTime();
								isnewMsg = true;
								lastId = msg.guid;
							});
							
							if (i != current && isnewMsg) {
								$("#chatwindow" + i).addClass("elggchat_session_new_messages");
							}
							else {
								createCookie("chat_lastsessionId_"+i, lastId);
							}
						}
					}
				});
								
				// register submit events on message input
			/*	$(".elggchatinput textarea").keypress(function(e){
					$(this).height($(this).attr("scrollHeight"));
					
					if (e.which == 13) {
						var input = $.trim($(this).val());
						
						if(input != ""){
							$.post("<?php echo $CONFIG->wwwroot;?>action/elggchat/post_message", $(this).parent().serialize(), function(data){
								checkForSessions();
							});
						}
						// empty input field
						$(this).val("");
						$(this).height(15);
					}
				});/**/
				$(".elggchatinput textarea").keyup(function(e){
					$(this).height($(this).attr("scrollHeight"));
					
					if (e.which == 13) {
						var input = $.trim($(this).val());
						
						if(input != ""){
							$.post("<?php echo $CONFIG->wwwroot;?>action/elggchat/post_message", $(this).parent().serialize(), function(data){
								checkForSessions();
							});
						}
						// empty input field
						$(this).val("");
						$(this).height(15);
					}
				});
				
				if ($("#chatwindow"+current+" .chatsessiondatacontainer").css('display') != 'block') {
					openSession(current);
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
		if (id == null || id == '') return;
		
		$("#chatwindow"+ id).removeClass("elggchat_session_new_messages");
		var current = $("#chatwindow" + id + " .chatsessiondatacontainer").css("display");
		eraseCookie("elggchat");
		$("#elggchat_sessions .chatsessiondatacontainer").hide();
		$("#elggchat_sessions .session").removeClass("chatsession_Active");
		if(current != "block"){
			createCookie("elggchat", id);
			eraseCookie("chat_lastsessionId_"+id);
			var last = $("#chatwindow" + id + " .chatmessages div:last").attr("id");
			$("#chatwindow" + id + " .chatsessiondatacontainer").toggle();
			$("#chatwindow" + id).toggleClass("chatsession_Active");
		}
		$("#chatwindow" + id + " input[name='chatmessage']").focus();
		scroll_to_bottom(id);
	}
	
	
	
	
	
	
	/* Some function by KimKha */
	function insertMessage(sessionid, msg) {
		var last = $("#chatwindow" + sessionid + " .chatmessages div:last-child");
		var newsession = "";
		var uid = parseInt(msg.guid);
		
		if (uid == 0) {
			newsession = "<div name='message' id='" + msg.offset + "' class='systemMessageWrapper'>";
			newsession += msg.content;
			newsession += "</div>";
			$("#chatwindow" + sessionid + " .chatmessages").append(newsession);
			scroll_to_bottom(sessionid);
			eraseCookie("chat_current_time_"+sessionid);
			return true;
		}
		
		if (typeof(last) != "undefined") {
			var msgGUID = last.find(".messageGUID").html();
			var msgcontent = last.find(".messageContent").html();
			
			var msgtime = readCookie("chat_current_time_"+sessionid);
			
			if (msgGUID != null && msgGUID != '') {
				msgGUID = parseInt(msgGUID);
				msgtime = (msgtime == msg.time)?'':"<div class='messageTime'>" + msg.time + "</div>";
				
				if (msgGUID == uid) {
					last.find(".messageContent").html(msgcontent + msgtime + "<p>" + msg.content + "</p>");
					scroll_to_bottom(sessionid);
					createCookie("chat_current_time_"+sessionid, msg.time, 1);
					return true;
				}
			}
		}
		
		newsession = "<div name='message' id='" + msg.offset + "' class='messageWrapper'>";
		newsession += "<div class='messageWrap'><div class='messageGUID'>" + msg.guid + "</div>";
		newsession += "<div class='messageTime'>" + msg.time + "</div>";
		newsession += "<div class='messageName'>" + msg.name + "</div></div>";
		newsession += "<div class='messageContent'><p>" + msg.content + "</p></div>";
		newsession += "</div>";
		$("#chatwindow" + sessionid + " .chatmessages").append(newsession);
		scroll_to_bottom(sessionid);
		createCookie("chat_current_time_"+sessionid, msg.time, 1);
		return true;
	}
	
	function autoHideChatWindow() {
		var kids = $("#elggchat_sessions").children();
		if (kids.length > maxVisibleWindow) {
			leftHide = kids.length - maxVisibleWindow;
			rightHide = kids.length-1;
			$("#elggchat_sessions").children("div:lt("+leftHide+")").css("display", "none");
			displayButton("inline");
		}
		else displayButton("none");
	}
	
	function displayButton(value) {
		$("#elggchat_sessions_wrapper_previous").css("display", value);
		$("#elggchat_sessions_wrapper_next").css("display", value);
	}
	
	function floatChatWindow(step) {
		var kids = $("#elggchat_sessions").children();
		rightHide += step;
		leftHide += step;
		
		if (rightHide > kids.length-1 || leftHide < 0) {
			rightHide -= step;
			leftHide -= step;
			return;
		}
		
		$("#elggchat_sessions").children("div").css("display", "block");
		$("#elggchat_sessions").children("div:lt("+leftHide+")").css("display", "none");
		$("#elggchat_sessions").children("div:gt("+rightHide+")").css("display", "none");
		
		displayButton("inline");
		if (kids.length < maxVisibleWindow) displayButton("none");
	}
	
	function splitname(name, num) {
		if (name.length > num) return name.substring(0,num-1)+"..";
		return name;
	}
	
	/* End: KimKha */
	
	
	
	
	
	
	
	$(document).ready(function(){
		elggchat_toolbar_resize();
		$(window).resize(function(){
			elggchat_toolbar_resize();
		});
		InitializeTimer();
		checkForSessions();
	});
	