<?php
/**
* iZAP izap_videos
*
* @package youtube, vimeo, veoh and onserver uploading
* @license GNU Public License version 3
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.5-2.0
*/
include $CONFIG->pluginspath . 'izap_videos/classes/izapLib.php';
// lets start every thing
function izap_videos_init()
{
	global $CONFIG;
  
  // check plugins settings, but displays the error only if admin is logged in
  //not needed now
  //  if(isadminloggedin())
  //  izapCheckPluginSettings_izap_videos(TRUE);
  
  // define some global settings for izap_videos
  $CONFIG->izap_videos = array();
  $CONFIG->izap_videos['playerPath'] = $CONFIG->wwwroot . "mod/izap_videos/player";
  $CONFIG->izap_videos['allowedExtensions'] = array('avi', 'flv', '3gp', 'mp4');
  
  // set the menu options
	if(isloggedin())
		add_menu(elgg_echo('videos'), $CONFIG->wwwroot . "pg/izap_videos/" . $_SESSION['user']->username);
	else
		add_menu(elgg_echo('videos'), $CONFIG->wwwroot . "mod/izap_videos/all.php");

// allow tags in the config 
    $CONFIG->allowedtags['object'] = array( 'width'=>array(), 'height'=>array(), 'classid'=>array(), 'codebase'=>array() , 'data' =>array(), 'type'=>array());
    $CONFIG->allowedtags['param'] = array( 'name'=>array(), 'value'=>array());
    $CONFIG->allowedtags['embed'] = array( 'src'=>array(), 'type'=>array(), 'wmode'=>array(), 'width'=>array(), 'height'=>array());

// register the notification hook
  if(is_callable('register_notification_object'))
    register_notification_object('object', 'izap_videos', elgg_echo('izap_videos:newVideoAdded'));

// lets extend some views
	extend_view('css','izap_videos/css');
	extend_view('metatags','izap_videos/javascript');
	extend_view('profile/menu/links','izap_videos/menu');
	extend_view('groups/menu/links','izap_videos/menu');
	extend_view('groups/left_column', 'izap_videos/gruopprofile_izapVideos');

  // only if enabled by admin
  if(izapIncludeIndexWidget_izap_videos())
    extend_view('index/righthandside', 'izap_videos/customindexVideos');

  // asking group to include the izap_videos
  add_group_tool_option('izap_videos', elgg_echo('izap_videos:group:enablevideo'), true);

  // registere some settings
	register_entity_url_handler('izap_videos_urlhandler','object','izap_videos');
	register_page_handler('izap_videos','izap_videos_pagehandler');

  // register the actions
  register_action('izap_videos/add',false,$CONFIG->pluginspath . "izap_videos/actions/add.php");
  register_action('izap_videos/edit',false,$CONFIG->pluginspath . "izap_videos/actions/edit.php");
  register_action('izap_videos/copy',false,$CONFIG->pluginspath . "izap_videos/actions/copy.php");
  register_action('izap_videos/delete',false,$CONFIG->pluginspath . "izap_videos/actions/delete.php");

  // adding the widget
  add_widget_type('izap_videos',elgg_echo('izap_videos:videos'),elgg_echo('izap_videos:widget'));
  
  // finally lets register the object
  register_entity_type('object','izap_videos');
}

function izap_videos_pagehandler($page)
{
	if(isset($page[0]) && $page[0] != '')
	{
		set_input('username',$page[0]);
	}else{
    @include(dirname(__FILE__) . "/all.php");
		return true;
  }
	
	if(isset($page[1]))
	{
		switch($page[1]){
		
			case "add":
			@include(dirname(__FILE__) . "/add.php");
			return true;
			
			case "play":
			set_input('izap_videos_video',$page[2]);
			@include(dirname(__FILE__) . "/play.php");
			return true;
			
			case "all":
			@include(dirname(__FILE__) . "/all.php");
			return true;
			
			case "frnd":
			@include(dirname(__FILE__) . "/frnd.php");
			return true;
			
			case "queue":
			@include(dirname(__FILE__) . "/queue.php");
			return true;
			
			case "edit":
			set_input('id',$page[2]);set_context('izap_videos_edit');
			@include(dirname(__FILE__) . "/edit.php");
			return true;

      case "embed":
			@include(dirname(__FILE__) . "/embed.php");
			return true;
						
			default:
			@include(dirname(__FILE__) . "/index.php");
			return true;
		}
	}
	else
	{
		@include(dirname(__FILE__) . "/index.php");
		return true;
	}
	
return false;
}

function izap_videos_pagesetup()
{
	global $CONFIG;
	
	$pageowner = page_owner_entity();
  $context = get_context();
  $allowedContext = array('izap_videos', 'izap_videos_copy', 'izap_videos_edit');

  // for izap_videos only
  if(in_array($context, $allowedContext)){
   if(isloggedin() && get_loggedin_userid() == $pageowner->guid){
      add_submenu_item(sprintf(elgg_echo('izap_videos:videos'),$pageowner->name), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username, 'izap_videos');
        if($pageowner instanceof ElggUser) // only for users
        add_submenu_item(sprintf(elgg_echo('izap_videos:frnd'),$pageowner->name), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username . "/frnd", 'izap_videos');
    }elseif($pageowner){
      // if not logged in and we have page owner
        add_submenu_item(sprintf(elgg_echo('izap_videos:user'),$pageowner->name), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username, 'izap_videos');
        if($pageowner instanceof ElggUser) // only for users
          add_submenu_item(sprintf(elgg_echo('izap_videos:userfrnd'),$pageowner->name), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username . "/frnd", 'izap_videos');
    }

  // logged in user can add video
  if(can_write_to_container(get_loggedin_userid(), page_owner()))
    add_submenu_item(elgg_echo('izap_videos:add'), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username . "/add", 'izap_videos');

    // for all we are in izap_videos
    add_submenu_item(elgg_echo('izap_videos:all'), $CONFIG->wwwroot . "pg/izap_videos", 'izap_videos');
  }

  // for groups
  if($pageowner instanceof ElggGroup && $context == 'groups'){
    if($pageowner->izap_videos_enable != 'no'){
      add_submenu_item(sprintf(elgg_echo('izap_videos:user'),$pageowner->name), $CONFIG->wwwroot . "pg/izap_videos/" . $pageowner->username, 'izap_videos');
    }
  }

  // for admin
  if(isadminloggedin() && $context == 'admin')
    add_submenu_item(elgg_echo('izap_videos:queueManagement'), $CONFIG->wwwroot . "pg/izap_videos/" . get_loggedin_user()->username . "/queue", 'IZAPVIDEOS');

}

function izap_parse_urls($text) {

       	return preg_replace_callback('/(^flv=)(?<!=["\'])((ht|f)tps?:\/\/[^\s\r\n\t<>"\'\!\(\)]+)/i',
       	create_function(
            '$matches',
            '
            	$url = $matches[1];
            	$urltext = str_replace("/", "/<wbr />", $url);
            	return "<a href=\"$url\" style=\"text-decoration:underline;\">$urltext</a>";
            '
        ), $text);
    }


function izap_videos_urlhandler($izap_videos_video)
{
	global $CONFIG;
	return $CONFIG->url . "pg/izap_videos/" . $izap_videos_video->getOwnerEntity()->username . "/play/" . $izap_videos_video->getGUID();
}

// finally register evert thing with the elgg system
register_elgg_event_handler('pagesetup','system','izap_videos_pagesetup');
register_elgg_event_handler('init','system','izap_videos_init', 1000);
