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

	 
include_once("class.curl.php");
class getFeed
{
	private $url;
	private $type;
	private $feedArray = array();
	private $mainArray = array();
	private $returnArray = array();
	private $fileRead;
	private $buffer;
	private $input_file;

	
	function readFeed($url, $type)
	{
		$this->url = $url;
		$this->type = $type;
		
			$urltocapture =  new curl($this->url) ;
			$urltocapture->setopt(CURLOPT_GET, true) ;
			$this->fileRead = $urltocapture->exec();
			//c($this->fileRead);exit;
				if(empty($this->fileRead) or !$this->fileRead)
				return 101;
					
			$ext = new btext();
			$this->feedArray = $ext->xml2array($this->fileRead);
//      c($this->feedArray);
//      exit;
		switch($this->type)
		{
			case 'youtube':
				return $this->youtube();
			break;
			case 'vimeo':
				return $this->vimeo();
			break;
			case 'veoh':
				return $this->veoh();
			break;
			default:
				return FALSE;
			break;
		}
	}
		
	function youtube()
	{
		$this->mainArray = $this->feedArray['entry']['media:group'];
			if(empty($this->mainArray))
				return 101;

		$this->returnArray['title'] = $this->mainArray['media:title'];
		$this->returnArray['description'] = $this->mainArray['media:description'];
		$this->returnArray['videoThumbnail'] = $this->mainArray['media:thumbnail']['1_attr']['url'];
		$this->returnArray['videoSrc'] = $this->mainArray['media:content_attr']['url'];
		if(empty($this->returnArray['videoSrc'])) {
			$this->returnArray['videoSrc'] = $this->mainArray['media:content']['0_attr']['url'];
		}
		$this->returnArray['videoTags'] = $this->mainArray['media:keywords'];

		return $this->returnArray;
	}
	
	function vimeo()
	{
		$this->mainArray = unserialize($this->fileRead);
		$this->mainArray = $this->mainArray[0];
			if(empty($this->mainArray))
				return 101;
		
		$this->returnArray['title'] = $this->mainArray['title'];
		$this->returnArray['description'] = $this->mainArray['caption'];
		$this->returnArray['videoThumbnail'] = $this->mainArray['thumbnail_large'];
		$this->returnArray['videoSrc'] = 'http://vimeo.com/moogaloop.swf?clip_id='.$this->mainArray['clip_id'].'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1';
		$this->returnArray['videoTags'] = $this->mainArray['tags'];
		
		return $this->returnArray;
	}
	
	function veoh()
	{	
		if(isset($this->feedArray['rsp']['errorList']['error_attr']['aowPermalink'])) {
			return 102;
		}		
		
		$this->mainArray = $this->feedArray['rsp']['videoList']['video_attr'];
			if(empty($this->mainArray))
				return 101;
				
		$this->returnArray['title'] = $this->mainArray['title'];
		$this->returnArray['description'] = $this->mainArray['description'];
		$this->returnArray['videoThumbnail'] = ($this->mainArray['fullHighResImagePath']) ? $this->mainArray['fullHighResImagePath'] : $this->mainArray['highResImage'];
		$this->returnArray['videoSrc'] = 'http://www.veoh.com/veohplayer.swf?permalinkId=' . $this->mainArray['permalinkId'] . '&player=videodetailsembedded';
		$this->returnArray['videoTags'] = str_replace(" ", ",", $this->mainArray['tags']);

		return $this->returnArray;
	}
}
?>