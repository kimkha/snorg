<?php
$english = array(
	'friendrequest' => "Friend Request",
	'friendrequests' => "Friend Requests",
	'friendrequests:title' => "%s's Friend Requests",
	'newfriendrequests' => "New Friend Requests!",
	'friendrequest:add:exists' => "You've already requested to be friends with %s.",
	'friendrequest:add:failure' => "Sorry, because of a system error we were unable to complete your request. Please try again.",
	'friendrequest:add:successful' => "You have requested to be friends with %s. They must approve your request before they will show on your friends list.",
	'friendrequest:newfriend:subject' => "%s wants to be your friend!",
	'friendrequest:newfriend:body' => "%s wants to be your friend! But they are waiting for you to approve the request...so login now so you can approve the request!

You can view your pending friend requests at (Make sure you are logged into the website before clicking on the following link otherwise you will be redirected to the login page.):

	%s

(You cannot reply to this email.)",

	'friendrequest:successful' => "You are now friends with %s!",
	'friendrequest:remove:success' => "Successfully removed friend request.",
	'friendrequest:remove:fail' => "Unable to remove friend request.",
	'friendrequest:approvefail' => "Unknown error while trying to add %s as a friend!",
	'approve:title' => " %s has approved your request",
	'approve:content' => " Hi %s,
	
	%s has approved your friend request. Now you and %s are friends.
	
	You can view %s's profile at : http://localhost/snorg1/pg/profile/%s",
	'approve:system:notify' => "approve notify has been sended to %s",
);
				
add_translation("en",$english);
?>