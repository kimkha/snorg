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

class izapConvert
{
	private $invideo;
	private $outvideo;
  private $outimage;
	private $values = array();

	public $format = 'flv';

	function izapConvert($in = '')
	{
    $this->invideo = $in;
		$outputPath = substr($this->invideo, 0, -4);
		$this->outvideo =  $outputPath . '_c.' . $this->format;
		$this->outimage = $outputPath . '_i.png';
  }

	function convert()
	{
    $videoCommand = izapGetFfmpegVideoConvertCommand_izap_videos();
    $videoCommand = str_replace('[inputVideoPath]', $this->invideo, $videoCommand);
    $videoCommand = str_replace('[outputVideoPath]', $this->outvideo, $videoCommand);
    $videoCommand .= ' 2>&1';
    
		exec($videoCommand, $arr, $ret);
    
		if(!$ret == 0){
      $return = array();
      $return['error'] = 1;
      $return['message'] = end($arr);
      $return['completeMessage'] = implode(' ', $arr);

      return $return;
    }

		return end(explode('/', $this->outvideo));
	}

	function photo()
	{
    $videoThumb = izapGetFfmpegVideoImageCommand_izap_videos();
    $videoThumb = str_replace('[inputVideoPath]', $this->invideo, $videoThumb);
    $videoThumb = str_replace('[outputImage]', $this->outimage, $videoThumb);

    // run command to take snapshot
		exec($videoThumb, $out2, $ret2);

		if(!$ret2 == 0)
			return FALSE;

		return $this->outimage;
	}

	function getValues()
	{
		$this->values['origname'] = time() . '_' . end(explode('/', $this->invideo));
	 	$this->values['origcontent'] = file_get_contents($this->invideo);
		$this->values['filename'] = time() . '_' . end(explode('/', $this->outvideo));
	 	$this->values['filecontent'] = file_get_contents($this->outvideo);
		$this->values['imagename'] = time() . '_' . end(explode('/', $this->outimage));
	 	$this->values['imagecontent'] = file_get_contents($this->outimage);
    if($this->values['filecontent'] != ''){
      if(file_exists($this->invideo))
        @unlink($this->invideo);
      if(file_exists($this->outvideo))
        @unlink($this->outvideo);
      if(file_exists($this->outimage))
        @unlink($this->outimage);
    }

		return $this->values;
	}
}
