<?php
// Image Rotator by Pappy Da Ripper


// Set image filename extensions
	$extList = array();
	$extList['gif'] = 'image/gif';
	$extList['jpg'] = 'image/jpg';
	$extList['jpeg'] = 'image/jpeg';
	$extList['png'] = 'image/png';

// Get contents of current directory
	$fileList = array();
	$handle = opendir("./");
	while ( false !== ( $file = readdir($handle) ) ) {
		$file_info = pathinfo($file);
		if (
		    isset( $extList[ strtolower( $file_info['extension'] ) ] )
		) {
			$fileList[] = $file;
		}
	}
	closedir($handle);

	if (count($fileList) > 0) {
		$imageNumber = time() % count($fileList);
		$img = $fileList[$imageNumber];
	}

if ($img!=null) {
	$imageInfo = pathinfo($img);
	$contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
	header ($contentType);
	readfile($img);
} else {
	if ( function_exists('imagecreate') ) {
		header ("Content-type: image/png");
		$im = @imagecreate (100, 100)
		    or die ("Cannot initialize new GD image stream");
		$background_color = imagecolorallocate ($im, 255, 255, 255);
		$text_color = imagecolorallocate ($im, 0,0,0);
		imagestring ($im, 2, 5, 5,  "IMAGE ERROR", $text_color);
		imagepng ($im);
		imagedestroy($im);
	}
}

?>