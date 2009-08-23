<?php
	/**
	 * iZAP izap_videos
	 * 
	 * @package youtube, vimeo, veoh
	 * @license GNU Public License version 3
	 * @author iZAP Team "<support@izap.in>"
	 * @link http://www.izap.in/
	 */
class izapDownload {
	private $input_file; // variable to get the input file name//
	private $output_file; // variable to get the output file name//
	private $buffer; // variable to store the input file content //
	private $save_location; // variable to store the new file save location //
	
	public function loadFile($in) // public function loads the file, takes the input file path as input parameter//
	{
		$this->buffer = ''; // empty the current buffer //
		$this->input_file = $in; // store the input file name //
		$input = fopen($this->input_file,"r"); // set handler for the input file to open it in read mode //
		
		while(!feof($input)) // start loop to get the file contendts //
		{
			$this->buffer .= fgets($input, 1024); // store the file cotnets in the buffer //
		}
		fclose($input); // close the current connection //
		
		return $this->buffer;
	}
	
	public function setLocation($loc) // public function for storing the location to save the file , takes the save location as input paramerter //
	{
		$this->save_location = $loc; // stores the value in variable //
	}
	
	public function setName($name) // public function for storing the name of the new file , takes the name as input paramerter //
	{
		$this->output_file = $name; // stores the value in variable //
	}
	
	public function getContents($in) // public function for reading the contents of a partucular file, takes file name as input //
	{
		return $this->loadFile($in); // returns the return value of the loadFile function //
	}
	
	public function saveFile($in, $loc, $name) // public function for actully saving the file //
	{
		$this->loadFile($in); // loades the given file in the buffer //
		$this->setLocation($loc); // sets location for the saving the file //
		$this->setName($name); // sets the name for saving the file with the extension //
		
		if(!is_dir($this->save_location)) // checks if the directory already exits or not, if not the proceeds in the condition//
		{
			if(!mkdir($this->save_location)) // checks if the directory is created ot not, if not the proceeds in the condition//
			{
				echo $this->save_location;
				echo "Can't Create Directory"; // if can't create directory then prints the msg //
				return FALSE;
			}
			
			chmod($this->save_location,0777);
		}
		
		$output = fopen($this->save_location . '/' . $this->output_file, "w"); // opens the file for writing //
		fwrite($output,$this->buffer);
		fclose($output);

		return TRUE;
		
	}
}
// Class ends //
?>
