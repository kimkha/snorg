<?php

require_once(dirname(dirname(__FILE__)) . "/engine/start.php");

$user = get_user($_GET['userid']);

// Set the content-type
header('Content-type: image/png');

// Create the image
$im = @imagecreatetruecolor(270, 16)
	or die("Cannot create image");

imagealphablending($im, false);
imagesavealpha($im, true);

// Create some colors
$nocolor = imagecolorallocatealpha($im, 255, 255, 255, 127);
$white = imagecolorallocatealpha($im, 255, 255, 255, 0);
$grey = imagecolorallocatealpha($im, 100, 100, 100, 0);
$black = imagecolorallocatealpha($im, 0, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $nocolor);

// The text to draw
$text = $user->email;
// Replace path by your own font path
$font = 'segoesc.ttf';

// Add some shadow to the text
//imagettftext($im, 10, 0, 3, 12, $grey, $font, $text);

// Add the text
imagettftext($im, 10, 0, 3, 12, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);
?> 
