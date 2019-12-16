<?php
//echo '<pre>';print_r($_POST);print_r($_FILES);echo '</pre>';
// process post data
if (!empty($_POST['url'])) {
	$bgImgPath = $_POST['url'];
}
elseif (!empty($_FILES['file']['tmp_name'])) {
	$bgImgPath = $_FILES['file']['tmp_name'];
}
else {
	//require 'index.php'; // load the user form
	//die();
}
//$bgImgPath = "something_burning.jpg";

$bgImgType = exif_imagetype( $bgImgPath ); // 2 = jpg, 3 = png
if ($bgImgType === 2) {
	$format = 'jpeg'; // note the difference between jpeg and jpg
	$bgImg = imagecreatefromjpeg($bgImgPath); // user image
}
elseif($bgImgType === 3) {
	$format = 'png';
	$bgImg = imagecreatefrompng($bgImgPath); // user image
}
else { die ("Error: Image type is not jpg or png."); }

$bgImageWidth = imagesx($bgImg);
$bgImageHeight = imagesy($bgImg);

// young man image
$youngMan = imagecreatefrompng('images/image_edited.png');
$youngManImageWidth = imagesx($youngMan);
$youngManImageHeight = imagesy($youngMan);

// calculate the size required for an image to fill a third of the background image - returns array
function image_background_dimentions($background_width, $img_width, $img_height)
{
  $background_width_percantage = ($background_width / $img_width) * 100;
  $new_img_height = ($img_height / 100) * $background_width_percantage;
  $new_img['width'] = $background_width * 0.45;
  $new_img['height'] = $new_img_height * 0.45;
  return $new_img;
}

$manImageDimentions = image_background_dimentions($bgImageWidth, $youngManImageWidth, $youngManImageHeight);
//print_r($manImageDimentions);
imagecopyresized($bgImg, $youngMan, (($bgImageWidth - $manImageDimentions['width']) + 1), (($bgImageHeight - $manImageDimentions['height']) + 1), 0, 0, $manImageDimentions['width'], $manImageDimentions['height'], $youngManImageWidth, $youngManImageHeight);
//imagecopy($bgImg, $youngMan, 0, 0, 100, 0, $bgImageWidth, $bgImageHeight);

// prepare caption
$caption = "SHIT'S ON FIRE, YO";
$captionFontSize = 96; // default (should look ok on "large" images)

// the caption width should be about two thirds of the image width. This feels like a hack, but it's how I solved it :P
do {
	// create a test box usaing the caption
	$captionBoxDimentions = imagettfbbox( $captionFontSize , 0.0 , __dir__."/fonts/impact.ttf" , $caption ); // size of box needed for text
	// get width and height of the test box
	$captionBoxDimentionsWidth = (abs($captionBoxDimentions[0]) + abs($captionBoxDimentions[2]) + 12);
	$captionBoxDimentionsHeight = (abs($captionBoxDimentions[1]) + abs($captionBoxDimentions[7]) + 12);
	$captionFontSize = $captionFontSize - 4; // reduce size for next iteration
} while ( ($bgImageWidth * 0.66) < $captionBoxDimentionsWidth ); // test the size of the box width, against the background image width

$captionFontSize = $captionFontSize + 4; // reset the last subtraction caused by the conditional XD
// now the correct box size has been calculated, we can make the caption box
$captionImgCreate = imagecreatetruecolor($captionBoxDimentionsWidth, $captionBoxDimentionsHeight);
$font_color = imagecolorallocate($captionImgCreate, 255, 255, 255);
$stroke_color = imagecolorallocate($captionImgCreate, 0, 0, 0);

// this function gives text an outline/stroke
function image_ttf_stroke_text(&$bgImg, $captionFontSize, $angle, $x, $y, &$textColor, &$strokeColor, $fontFile, $text, $strokeWidth)
{
	for($c1 = ($x-abs($strokeWidth)); $c1 <= ($x+abs($strokeWidth)); $c1++)
		for($c2 = ($y-abs($strokeWidth)); $c2 <= ($y+abs($strokeWidth)); $c2++)
			$bg = imagettftext($bgImg, $captionFontSize, $angle, $c1, $c2, $strokeColor, $fontFile, $text);

	return imagettftext($bgImg, $captionFontSize, $angle, $x, $y, $textColor, $fontFile, $text);
}
// fill the captopn box with the caption stroke/outline text
$captionImg = image_ttf_stroke_text($bgImg, $captionFontSize, 0, 10, ($bgImageHeight - 10), $font_color, $stroke_color, __dir__."/fonts/impact.ttf", $caption, 2);

// Output the result
// Set the content type header - in this case image/png
/*
if ($bgImgType === 2) {
	// Set the content type header - in this case image/jpeg
	header('Content-Type: image/jpeg');
	// Output the image
	imagejpeg($bgImg);
}
elseif($bgImgType === 3) {
	// Set the content type header - in this case image/png
	header('Content-Type: image/png');
	// Output the image
	imagepng($bgImg);
}
// Free up memory
imagedestroy($bgImg);
*/

// Example

// Create an HTML Img Tag with Base64 Image Data
function gdImgToHTML( $bgImg, $format ) {
	ob_start();
	// Validate Format
	if ($format === 'jpeg') {
		imagejpeg($bgImg);
	}
	elseif($format === 'png') {
		imagepng($bgImg);
	}
	$data = ob_get_contents();
	ob_end_clean();

	// Check for gd errors / buffer errors
	if( !empty($data) ) {
		$data = base64_encode( $data );
		// Check for base64 errors
		if ( $data !== false ) {
			// Success
			return "\"data:image/$format;base64,$data\"";
		}
	}
    // Failure
    return '<h3>Error: gdImgToHTML()</h3>';
}

?>
