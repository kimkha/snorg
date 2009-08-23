<?php
/**
* iZAP izap_videos
*
* @package youtube, vimeo, veoh and onserver uploading
* @license GNU Public License version 3
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.5-1.0

* @Youtube player by Mark Harding
*/

include_once("getFeed.php");
class izapVideo extends getFeed
{
	private $youtube_api_capture = array('api_location'=>'http://gdata.youtube.com/feeds/api/videos/');
	private $vimeo_api_capture = array('api_location' => 'http://vimeo.com/api/clip/');
	private $veoh_api_capture = array('api_location'=>'http://www.veoh.com/rest/v2/execute.xml?method=veoh.video.findByPermalink','apiKey'=>'CFEDBB8B-59FB-D36B-7435-E4B39C5D39A2');
	private $feed;
	public  $type;
	private $video_id;
	
	function izapVideo($url = '')
	{
		
		if (preg_match('/(http:\/\/)?(www\.)?(youtube\.com\/)(.*)/', $url, $matches))
		{
			$this->type = 'youtube';
		}
		elseif (preg_match('/(http:\/\/)?(www\.)?(vimeo\.com\/)(.*)/', $url, $matches))
		{
			$this->type = 'vimeo';
		}
		elseif (preg_match('/(http:\/\/)?(www\.)?(veoh\.com\/)(.*)/', $url, $matches))
		{
			$this->type = 'veoh';
		}
			
		switch($this->type)
		{
			case 'youtube':
			  $url_pram = explode("?",$url);
			  $url_pram = explode("&",$url_pram[1]);
			  $url_pram = explode("=",$url_pram[0]);
			  $this->video_id = $url_pram[1];
			  $this->feed = array('url' => $this->youtube_api_capture['api_location'].$this->video_id, 'type' => 'youtube');
			break;
			
			case 'vimeo':
				$url_pram = explode("/",$url);
				$this->video_id = end($url_pram);
				$this->feed = array('url' => $this->vimeo_api_capture['api_location'].$this->video_id.'.php', 'type' => 'vimeo');
			break;
			
			case 'veoh':
				$video_id = end(explode("%",$url));
				$this->video_id = substr($video_id, 2);
                $chk = strtolower(substr($this->video_id, 0, 1));
                if($chk != 'v') {
                    $this->video_id = end(explode("/",$url));
                }
				$this->feed = array('url' => $this->veoh_api_capture['api_location'].'&apiKey='.$this->veoh_api_capture['apiKey'].'&permalink='.$this->video_id, 'type' => 'veoh');
			break;
		}
	}
	
	function capture()
	{
				
	  $obj= new stdClass;
		
	  $arry = $this->readFeed($this->feed['url'], $this->feed['type']);

	  $obj->title = $arry['title'];
	  $obj->description = $arry['description'];
	  $obj->videoThumbnail = $arry['videoThumbnail'];
	  $obj->videoTags = $arry['videoTags'];
	  $obj->videoSrc = $arry['videoSrc'];
	  	if(empty($obj->title) or empty($obj->videoSrc) or empty($obj->videoThumbnail)) {
			return $arry;
		}
	  $obj->fileName = time() . $this->video_id . ".jpg";
	  
		$urltocapture =  new curl($obj->videoThumbnail) ;
		$urltocapture->setopt(CURLOPT_GET, true) ;
	
	  $obj->fileContent = $urltocapture->exec();
		
	  $obj->type = $this->feed['type'];
	  //echo "<pre>";print_r($obj);
	  return $obj;      
	}
	
	
	
  function izap_video_object($type, $url, $width, $height, $play, $player_path = '', $izapPath = '', $options = '')
  {
      $type = strtolower($type);
    switch ($type) 
    {
      case 'youtube':
        $videodiv = "
		<script type=\"text/javascript\" src=\"$player_path/swfobject.js\"></script>
		<object id=\"player\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" name=\"player\" width=" . $width ." height=". $height . ">
		 <param name=\"movie\" value=\"$player_path/player.swf\" />
          <param name=\allowfullscreen\" value=\"true\" />
          <param name=\"allowscriptaccess\" value=\"always\" />
          <param name=\"flashvars\" value=\"file={$url}&hl=en&fs=1&hd=1&autostart={$play}&skin=/mod/izap_videos/player/stylish_slim.swf&stretching=fit\" />
          <object type=\"application/x-shockwave-flash\" data=\"$player_path/player.swf\" width=\"$width\" height=\"$height\">
            <param name=\"movie\" value=\"$player_path/player.swf\" />
            <param name=\"allowfullscreen\" value=\"true\" />
            <param name=\"allowscriptaccess\" value=\"always\" />
            <param name=\"flashvars\" value=\"file={$url}&hl=en&fs=1&autostart={$play}&skin=$player_path/stylish_slim.swf&stretching=fit\" />
          </object>
        </object>";
        break;
      case 'vimeo':
        $videodiv = "
		<object width=\"$width\" height=\"$height\"><param name=\"allowfullscreen\" value=\"true\" /><param name=\"allowscriptaccess\" value=\"always\" /><param name=\"movie\" value=\"{$url}&amp;autoplay={$play}\" /><embed src=\"{$url}&amp;autoplay={$play}\" type=\"application/x-shockwave-flash\" allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"$width\" height=\"$height\"></embed></object>";
        break;
      case 'veoh':
        $videodiv = "<embed src=\"{$url}&videoAutoPlay={$play}\" allowFullScreen=\"true\" width=\"$width\" height=\"$height\" bgcolor=\"#FFFFFF\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed>";
        break;
      case 'uploaded':
        $videodiv = "
				<script type=\"text/javascript\" src=\"$player_path/swfobject.js\"></script>
		<object id=\"player\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" name=\"player\" width=" . $width ." height=". $height . ">
		 <param name=\"movie\" value=\"$player_path/player.swf\" />
          <param name=\allowfullscreen\" value=\"true\" />
          <param name=\"allowscriptaccess\" value=\"always\" />
          <param name=\"flashvars\" value=\"file={$url}.flv&autostart={$play}&skin=/mod/izap_videos/player/stylish_slim.swf&stretching=fit\" />
          <object type=\"application/x-shockwave-flash\" data=\"$player_path/player.swf\" width=\"$width\" height=\"$height\">
            <param name=\"movie\" value=\"$player_path/player.swf\" />
            <param name=\"allowfullscreen\" value=\"true\" />
            <param name=\"allowscriptaccess\" value=\"always\" />
            <param name=\"flashvars\" value=\"file={$url}.flv&autostart={$play}&skin=$player_path/stylish_slim.swf&stretching=fit\" />
          </object>
        </object>";
        break;
      case 'embed':
        $videodiv = preg_replace('/width=["\']\d+["\']/', 'width="' . $width . '"', $url);
        $videodiv = preg_replace('/width:\d+/', 'width:'.$width, $videodiv);
        $videodiv = preg_replace('/height=["\']\d+["\']/', 'height="' . $height . '"', $videodiv);
        $videodiv = preg_replace('/height:\d+/', 'height:'.$height, $videodiv);
        break;
      default:
        return FALSE;
    }
    return $videodiv;
  }

}