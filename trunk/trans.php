<?php

if ($_POST['key']!='')
{
	$key = $_POST['key'];
	$message = $_POST['message'];
	$newstring = "'{$key}' => '{$message}',\n\t";
	
	$str = split(":", $key);
	$mod = $str[0];
	
	$filename = "languages/vi.php";
	if (is_dir("mod/".$mod)) {
		$filename = "mod/".$mod."/".$filename;
	}
	
	if (!file_exists($filename)) {
		$cont = "<?php

\$vietnamese = array(
	// NEW STRING HERE
	// END NEW STRING
);

add_translation('vi', \$vietnamese);

?>";
		$handle = fopen($filename, 'w');
		fwrite($handle, $cont);
		fclose($handle);
	}
	
	$findstring = "// END NEW STRING";
	$handle = fopen($filename, 'r');
	$content = fread($handle, filesize($filename));
	fclose($handle);
	
	$cont = str_replace($findstring, $newstring.$findstring, $content);
	
	$handle = fopen($filename, 'w');
	fwrite($handle, $cont);
	fclose($handle);
}
?>