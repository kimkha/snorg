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

class curl
{
	/**
	 * The mapping to caseless header names.
	 *
	 * @access private
	 * @var array
	 */

	var $m_caseless ;

	/**
	 * The handle for the current curl session.
	 *
	 * @access private
	 * @var resource
	 */

	var $m_handle ;

	/**
	 * The parsed contents of the HTTP header if one happened in the
	 * message.  All repeated elements appear as arrays.
	 *
	 * The headers are stored as an associative array, the key of which
	 * is the name of the header, e.g., Set-Cookie, and the values of which
	 * are the bodies of the header in the order in which they occurred.
	 *
	 * Some headers can be repeated in a single header, e.g., Set-Cookie and
	 * pragma, so each type of header has an array containing one or more
	 * headers of the same type.
	 *
	 * The names of the headers can, potentially, vary in spelling from
	 * server to server and client to client.  No attempt to regulate this
	 * is made, i.e., the curl class does not force all headers to lower
	 * or upper class, but it DOES collect all headers of the same type
	 * under the spelling of the type of header used by the FIRST header
	 * of that type.
	 *
	 * For example, two headers:
	 *
	 *   1. Set-Cookie: ...
	 *   2. set-cookie: ...
	 *
	 * Would appear as $this->m_header['Set-Cookie'][0] and ...[1]
	 *
	 * @access private
	 * @var mixed
	 */

	var $m_header ;

	/**
	 * Current setting of the curl options.
	 *
	 * @access private
	 * @var mixed
	 */

	var $m_options ;

	/**
	 * Status information for the last executed http request.  Includes the errno and error
	 * in addition to the information returned by curl_getinfo.
	 *
	 * The keys defined are those returned by curl_getinfo with two additional
	 * ones specified, 'error' which is the value of curl_error and 'errno' which
	 * is the value of curl_errno.
	 *
	 * @link http://www.php.net/curl_getinfo
	 * @link http://www.php.net/curl_errno
	 * @link http://www.php.net/curl_error
	 * @access private
	 * @var mixed
	 */

	var $m_status ;

	/**
	 * Collection of headers when curl follows redirections as per CURLOPTION_FOLLOWLOCATION.
	 * The collection includes the headers of the final page too.
	 *
	 * @access private
	 * @var array
	 */

	var $m_followed ;

	/**
	 * curl class constructor
	 *
	 * Initializes the curl class for it's default behavior:
	 *  o no HTTP headers.
	 *  o return the transfer as a string.
	 *  o URL to access.
	 * By default, the curl class will simply read the URL provided
	 * in the constructor.
	 *
	 * @link http://www.php.net/curl_init
	 * @param string $theURL [optional] the URL to be accessed by this instance of the class.
	 */

	function curl($theURL=null)
	  {
		if (!function_exists('curl_init'))
		  {
			trigger_error('PHP was not built with --with-curl, rebuild PHP to use the curl class.',
						  E_USER_ERROR) ;
		  }

		$this->m_handle = curl_init() ;

		$this->m_caseless = null ;
		$this->m_header = null ;
		$this->m_options = null ;
		$this->m_status = null ;
		$this->m_followed = null ;

		if (!empty($theURL))
		  {
			$this->setopt(CURLOPT_URL, $theURL) ;
		  }
		$this->setopt(CURLOPT_HEADER, false) ;
		$this->setopt(CURLOPT_RETURNTRANSFER, true) ;
	  }

	/**
	 * Free the resources associated with the curl session.
	 *
	 * @link http://www.php.net/curl_close
	 */

	function close()
	  {
		curl_close($this->m_handle) ;
		$this->m_handle = null ;
	  }

	/**
	 * Execute the curl request and return the result.
	 *
	 * @link http://www.php.net/curl_exec
	 * @link http://www.php.net/curl_getinfo
	 * @link http://www.php.net/curl_errno
	 * @link http://www.php.net/curl_error
	 * @return string The contents of the page (or other interaction as defined by the
	 *                settings of the various curl options).
	 */

	function exec()
	  {
		$theReturnValue = curl_exec($this->m_handle) ;

		$this->m_status = curl_getinfo($this->m_handle) ;
		$this->m_status['errno'] = curl_errno($this->m_handle) ;
		$this->m_status['error'] = curl_error($this->m_handle) ;

		//
		// Collect headers espesically if CURLOPT_FOLLOWLOCATION set.
		// Parse out the http header (from last one if any).
		//

		$this->m_header = null ;

		//
		// If there has been a curl error, just return a null string.
		//

		if ($this->m_status['errno'])
		{
		  return '' ;
		}

		if ($this->getOption(CURLOPT_HEADER))
		  {

			$this->m_followed = array() ;
			$rv = $theReturnValue ;

			while (count($this->m_followed) <= $this->m_status['redirect_count'])
			  {
				$theArray = preg_split("/(\r\n){2,2}/", $rv, 2) ;

				$this->m_followed[] = $theArray[0] ;

				$rv = $theArray[1] ;
			  }

			$this->parseHeader($theArray[0]) ;

			return $theArray[1] ;
		  }
		else
		  {
			return $theReturnValue ;
		  }
	  }

	/**
	 * Returns the parsed http header.
	 *
	 * @param string $theHeader [optional] the name of the header to be returned.
	 *                          The name of the header is case insensitive.  If
	 *                          the header name is omitted the parsed header is
	 *                          returned.  If the requested header doesn't exist
	 *                          false is returned.
	 * @returns mixed
	 */

	function getHeader($theHeader=null)
	  {
		//
		// There can't be any headers to check if there weren't any headers
		// returned (happens in the event of errors).
		//

		if (empty($this->m_header))
		{
		  return false ;
		}

		if (empty($theHeader))
		  {
			return $this->m_header ;
		  }
		else
		  {
			$theHeader = strtoupper($theHeader) ;
			if (isset($this->m_caseless[$theHeader]))
			  {
				return $this->m_header[$this->m_caseless[$theHeader]] ;
			  }
			else
			  {
				return false ;
			  }
		  }
	  }

	/**
	 * Returns the current setting of the request option.  If no
	 * option has been set, it return null.
	 *
	 * @param integer the requested CURLOPT.
	 * @returns mixed
	 */

	function getOption($theOption)
	  {
		if (isset($this->m_options[$theOption]))
		  {
			return $this->m_options[$theOption] ;
		  }

		return null ;
	  }

	/**
	 * Did the last curl exec operation have an error?
	 *
	 * @return mixed The error message associated with the error if an error
	 *               occurred, false otherwise.
	 */

	function hasError()
	  {
		if (isset($this->m_status['error']))
		  {
			return (empty($this->m_status['error']) ? false : $this->m_status['error']) ;
		  }
		else
		  {
			return false ;
		  }
	  }

	/**
	 * Parse an HTTP header.
	 *
	 * As a side effect it stores the parsed header in the
	 * m_header instance variable.  The header is stored as
	 * an associative array and the case of the headers
	 * as provided by the server is preserved and all
	 * repeated headers (pragma, set-cookie, etc) are grouped
	 * with the first spelling for that header
	 * that is seen.
	 *
	 * All headers are stored as if they COULD be repeated, so
	 * the headers are really stored as an array of arrays.
	 *
	 * @param string $theHeader The HTTP data header.
	 */

	function parseHeader($theHeader)
	  {
		$this->m_caseless = array() ;

		$theArray = preg_split("/(\r\n)+/", $theHeader) ;

		//
		// Ditch the HTTP status line.
		//

		if (preg_match('/^HTTP/', $theArray[0]))
		  {
			$theArray = array_slice($theArray, 1) ;
		  }

		foreach ($theArray as $theHeaderString)
		  {
			$theHeaderStringArray = preg_split("/\s*:\s*/", $theHeaderString, 2) ;

			$theCaselessTag = strtoupper($theHeaderStringArray[0]) ;

			if (!isset($this->m_caseless[$theCaselessTag]))
			  {
				$this->m_caseless[$theCaselessTag] = $theHeaderStringArray[0] ;
			  }

			$this->m_header[$this->m_caseless[$theCaselessTag]][] = $theHeaderStringArray[1] ;
		  }
	  }

	/**
	 * Return the status information of the last curl request.
	 *
	 * @param string $theField [optional] the particular portion
	 *                         of the status information desired.
	 *                         If omitted the array of status
	 *                         information is returned.  If a non-existant
	 *                         status field is requested, false is returned.
	 * @returns mixed
	 */

	function getStatus($theField=null)
	  {
		if (empty($theField))
		  {
			return $this->m_status ;
		  }
		else
		  {
			if (isset($this->m_status[$theField]))
			  {
				return $this->m_status[$theField] ;
			  }
			else
			  {
				return false ;
			  }
		  }
	  }

	/**
	 * Set a curl option.
	 *
	 * @link http://www.php.net/curl_setopt
	 * @param mixed $theOption One of the valid CURLOPT defines.
	 * @param mixed $theValue the value of the curl option.
	 */

	function setopt($theOption, $theValue)
	  {
		curl_setopt($this->m_handle, $theOption, $theValue) ;
		$this->m_options[$theOption] = $theValue ;
	  }

	/**
	 * @desc Post string as an array
	 * @param string by reference data to be written.
	 * @return array hash containing the post string as individual elements, urldecoded.
	 * @access public
	 */

	function &fromPostString(&$thePostString)
	{
		$return = array() ;
		$fields = explode('&', $thePostString) ;
		foreach($fields as $aField)
		{
			$xxx = explode('=', $aField) ;
			$return[$xxx[0]] = urldecode($xxx[1]) ;
		}

		return $return ;
	}

	/**
	 * Arrays are walked through using the key as a the name.  Arrays
	 * of Arrays are emitted as repeated fields consistent with such things
	 * as checkboxes.
	 *
	 * @desc Return data as a post string.
	 * @param mixed by reference data to be written.
	 * @param string [optional] name of the datum.
	 * @access public
	 */

	function &asPostString(&$theData, $theName = NULL)
	  {
		$thePostString = '' ;
		$thePrefix = $theName ;

		if (is_array($theData))
		{
		  foreach ($theData as $theKey => $theValue)
		  {
			if ($thePrefix === NULL)
		{
			  $thePostString .= '&' . curl::asPostString($theValue, $theKey) ;
		}
		else
			{
			  $thePostString .= '&' . curl::asPostString($theValue, $thePrefix . '[' . $theKey . ']') ;
			}
		  }
		}
		else
		{
		  $thePostString .= '&' . urlencode((string)$thePrefix) . '=' . urlencode($theData) ;
		}

		$xxx =& substr($thePostString, 1) ;

		return $xxx ;
	  }

	/**
	 * Returns the followed headers lines, including the header of the retrieved page.
	 * Assumed preconditions: CURLOPT_HEADER and expected CURLOPT_FOLLOWLOCATION set.
	 * The content is returned as an array of headers of arrays of header lines.
	 *
	 * @param none.
	 * @returns mixed an empty array implies no headers.
	 * @access public
	 */

	function getFollowedHeaders()
	  {
		$theHeaders = array() ;
		if ($this->m_followed)
		  {
			foreach ( $this->m_followed as $aHeader )
			  {
				$theHeaders[] = explode( "\r\n", $aHeader ) ;
			  } ;
			return $theHeaders ;
		  }

		return $theHeaders ;
	  }
}


class xml2array
{

    /**
    *    constructor
    */
    function xml2array( $xml )
    {
        // check for file
        if ( file_exists($xml) )
            $xml = file_get_contents( $xml );

        // check for string, open in dom
        if ( is_string($xml) )
        {
            $xml = domxml_open_mem( $xml );
            $this->root_element = $xml->document_element();
        }

        // check for dom-creation,
        if ( is_object( $xml ) && $xml->node_type() == XML_DOCUMENT_NODE )
        {
            $this->root_element = $xml->document_element();
            return TRUE;
        }

        if ( is_object( $xml ) && $xml->node_type() == XML_ELEMENT_NODE )
        {
            $this->root_element = $xml;
            return TRUE;
        }

        return FALSE;
    }

    /**
    *    recursive function to walk through dom and create array
    */
    function _recNode2Array( $domnode )
    {
        if ( $domnode->node_type() == XML_ELEMENT_NODE )
        {

            $childs = $domnode->child_nodes();
            foreach($childs as $child)
            {
                if ($child->node_type() == XML_ELEMENT_NODE)
                {
                    $subnode = false;
                    $prefix = ( $child->prefix() ) ? $child->prefix().':' : '';
                    
                    // try to check for multisubnodes
                    foreach ($childs as $testnode)
                      if ( is_object($testnode) )
                        if ($child->node_name() == $testnode->node_name() && $child != $testnode)
                            $subnode = true;
                            
                    if ( is_array($result[ $prefix.$child->node_name() ]) )
                        $subnode = true;

                    if ($subnode == true)
                        $result[ $prefix.$child->node_name() ][]    = $this->_recNode2Array($child);
                    else
                        $result[ $prefix.$child->node_name() ]    = $this->_recNode2Array($child);
                }
            }
    
            if ( !is_array($result) ){
                // correct encoding from utf-8 to locale
                // NEEDS to be updated to correct in both ways!
                $result['#text']    =    html_entity_decode(htmlentities($domnode->get_content(), ENT_COMPAT, 'UTF-8'), ENT_COMPAT,'ISO-8859-15');
            }
    
            if ( $domnode->has_attributes() )
                foreach ( $domnode->attributes() as $attrib )
                {
                    $prefix = ( $attrib->prefix() ) ? $attrib->prefix().':' : '';
                    $result["@".$prefix.$attrib->name()]    =    $attrib->value();
                }

            return $result;
        }
    }

    /**
    *    caller func to get an array out of dom
    */
    function getResult()
    {
        if ( $resultDomNode = $this->root_element )
        {
            $array_result[ $resultDomNode->tagname() ] = $this->_recNode2Array( $resultDomNode );
            return $array_result;
        } else
            return false;
    }
    
    function getEncoding()
    {
        preg_match("~\<\?xml.*encoding=[\"\'](.*)[\"\'].*\?\>~i",$this->xml_string,$matches);
        return ($matches[1])?$matches[1]:"";
    }
    
    function getNamespaces()
    {
        preg_match_all("~[[:space:]]xmlns:([[:alnum:]]*)=[\"\'](.*?)[\"\']~i",$this->xml_string,$matches,PREG_SET_ORDER);
        foreach( $matches as $match )
            $result[ $match[1] ] = $match[2];
        return $result;
    }
}

class btext 
{

		function extract($string,$ot,$ct)
		{

			$string	= trim($string);
			$start	= intval(strpos($string,$ot) + strlen($ot));

			$mytext	= substr($string,$start,intval(strpos($string,$ct) - $start));

			return $mytext;
		}
		
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
    return($xml_array);
}  
		
	}
?>
