<html>
<head>
	<title>sksksk</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>

<?php

if ($_POST['key']!='')
{
	echo $_POST['message'];
	$newstring = "'{$_POST['key']}' => '{$_POST['message']}',\n\t";
	
	$findstring = "// END NEW STRING";
	$filename = "languages/vi.php";
	$handle = fopen($filename, 'r');
	$content = fread($handle, filesize($filename));
	fclose($handle);
	
	$cont = str_replace($findstring, $newstring.$findstring, $content);
	
	$handle = fopen($filename, 'w');
	fwrite($handle, $cont);
	fclose($handle);
}
else
{
	?>
	<form action="trans.php?" method="POST">
	Từ khóa: <input type="text" name="key" />
	Chuỗi được dịch: <input type="text" name="message" />
	<input type="submit" value="Lưu" />
	</form>
	<?php
}

?>
</body>
</html>