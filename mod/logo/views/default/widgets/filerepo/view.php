


<?php

    //the page owner
	$owner = $vars['entity']->owner_guid;
	
	//the number of files to display
	$number = (int) $vars['entity']->num_display;
	if (!$number)
		$number = 1;
	
	//get the layout view which is set by the user in the edit panel
	$get_view = (int) $vars['entity']->gallery_list;
	if (!$get_view || $get_view == 1) {
	    $view = "marquee";
    }else{
        $view = "notmarquee";
    }

	//get the user's files
	$files = get_user_objects(null, "file", $number, 0);
	
	//if there are some files, go get them
	if ($files) {
		
		if ( $view == "marquee" )
		{
			
    	
    	echo "<div id=\"filerepo_widget_layout\">";
        
       
        
        echo "<div class=\"filerepo_widget_galleryview\">";
        
       		$content = '<div><marquee style="margin: 0pt 5px; height: 300px;" onmouseout="this.start()" onmouseover="this.stop()" scrolldelay="1" scrollamount="2" direction="up">';
        
            //display in gallery mode
        foreach($files as $f){
        
	    	
           	
        $mime = $f->mimetype;
        
        
        $content.= '<div><a href="'.$f->description.'">'. elgg_view("file/icon", array("mimetype" => $mime, 'thumbnail' => $f->thumbnail, 'file_guid' => $f->guid,'size'=>'large')) . "</a></div>";
        
      
          
       
            				
         }
             $content.= '</marquee></div>';  
        echo $content;
            echo "</div>";
            echo "</div>";
            
       }
       else
       {
       		echo "<div id=\"filerepo_widget_layout\">";
        
       
        
      	  echo "<div class=\"filerepo_widget_galleryview\">";
        
        
        	
            
        foreach($files as $f){
            	
            	
        $mime = $f->mimetype;
        
        
        $content.= "<center><a href=\"hoai.com\">" . elgg_view("file/icon", array("mimetype" => $mime, 'thumbnail' => $f->thumbnail, 'file_guid' => $f->guid,'size'=>'large')) . "</a></center>";
  
        
        echo $content;
            				
         }
            
            echo "</div>";
            echo "</div>";
            
       }
        	
        	
  
        	
				
	} else {
		
		echo "<div class=\"contentWrapper\">" . 'No Logo Ads here' . "</div>";
		
	}

?>