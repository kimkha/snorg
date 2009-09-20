<?php

	$english = array(
	
		/**
		 * Menu items and titles
		 */
	
			'messageboard:board' => "Testimony Board",
			'messageboard:messageboard' => "Testimony Board",
			'messageboard:viewall' => "View all",
			'messageboard:postit' => "Post it",
			'messageboard:history' => "history",
			'messageboard:none' => "There is nothing on this testimony board yet",
			'messageboard:num_display' => "Number of testimony message  to display",
			'messageboard:desc' => "This is a testimony board that you can put on your profile where other users can comment.",
	
			'messageboard:user' => "%s's testimony board",
	
			'messageboard:history' => "History",
			
         /**
	     * Message board widget river
	     **/
	        
	        'messageboard:river:annotate' => "%s has had a new comment posted on their testimony board.",
	        'messageboard:river:create' => "%s added the testimony board widget.",
	        'messageboard:river:update' => "%s updated their testimony board widget.",
	        'messageboard:river:added' => "%s posted on",
		    'messageboard:river:messageboard' => "testimony board",

			
		/**
		 * Status messages
		 */
	
			'messageboard:posted' => "You successfully posted on the testimony board.",
			'messageboard:deleted' => "You successfully deleted the message.",
	
		/**
		 * Email messages
		 */
	
			'messageboard:email:subject' => 'You have a new testimony board comment!',
			'messageboard:email:body' => "You have a new testimony board comment from %s. It reads:

			
%s


To view your message board comments, click here:

	%s

To view %s's profile, click here:

	%s

You cannot reply to this email.",
	
		/**
		 * Error messages
		 */
	
			'messageboard:blank' => "Sorry; you need to actually put something in the message area before we can save it.",
			'messageboard:notfound' => "Sorry; we could not find the specified item.",
			'messageboard:notdeleted' => "Sorry; we could not delete this message.",
			'messageboard:somethingwentwrong' => "Something went wrong when trying to save your message, make sure you actually wrote a message.",
	     
			'messageboard:failure' => "An unexpected error occurred when adding your message. Please try again.",
	
	);
					
	add_translation("en",$english);

?>