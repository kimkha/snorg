

  <?php
  	require_once(dirname(__FILE__) . "/engine/start.php");


  	//Get guid of page owener
  	$owner =  get_user(get_input('owner'));
  	
  	//
  	//Get all friends of page owner
  	$friends = $owner->getFriends();	
  	
  	//response xml data of all page owner friends
  	echo "<Friends type=\"array\">";
  	$count = 0;
  	foreach ($friends as $friend){
  		echo "<index$count type = \"Friend\">
  				<username type=\"string\">". $friend->username ."</username>
  				<userurl type=\"string\">". $friend->getURL() ."</userurl>
  				<usericon type=\"string\">". $friend->getIcon('small') ."</usericon> 
  			</index$count>";
  			$count++;
  	}
 	
 	echo "</Friends>";
 ?>
 
