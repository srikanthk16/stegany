<?php
function imageMaker($filepath) { 
    $type = exif_imagetype($filepath);  
    $allowedTypes = array( 
        1,  // [] gif 
        2,  // [] jpg 
        3,  // [] png 
        6   // [] bmp 
    ); 
    if (!in_array($type, $allowedTypes)) { 
        return false; 
    } 
    switch ($type) { 
        case 1 : 
            $im = imageCreateFromGif($filepath); 
        break; 
        case 2 : 
            $im = imageCreateFromJpeg($filepath); 
        break; 
        case 3 : 
            $im = imageCreateFromPng($filepath); 
        break; 
        case 6 : 
            $im = imageCreateFromBmp($filepath); 
        break; 
    }    
    return $im;  
} 
$test='steg.png';
try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['userfile']['error']) ||
        is_array($_FILES['userfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['userfile']['error'] value.
    switch ($_FILES['userfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['userfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['userfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['userfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['userfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
	$test= sha1_file($_FILES['userfile']['tmp_name']).'.'.$ext;
    if (!move_uploaded_file(
        $_FILES['userfile']['tmp_name'],
        sprintf('./images/%s.%s',
            sha1_file($_FILES['userfile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
	
    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
$im=imagecreatefrompng('Images\\'.$test);
echo $test;
$text="this is sample text";
$keys_prim=array('g','r','b','b','r','g');
$keys_secon=array('r','b','g','r','g','b');
$rgb=imagecolorat($im,0,0);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$textarray=str_split($text);
$length=count($textarray);
$g=0;
$color=imagecolorallocate($im,$r,$length,$b);
imagesetpixel($im,0,0,$color);
$rgb=imagecolorat($im,0,1);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$k=rand(0,1);
$color=imagecolorallocate($im,$r,$k,$b);
imagesetpixel($im,0,1,$color);
$i=0;
$j=0;
$x=0;
for($i=2;$i<imagesx($im);$i++)
{
	for($j=2;$j<imagesy($im);$j++)
	{	$color=0;
		$rgb=imagecolorat($im,$i,$j);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		if($x<$length)
		{	
			if($k==0 && $i%2==0)
			{
			switch($x%6)
			{
			case 0:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 1:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			case 2:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 3:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 4:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 5:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			}
			$x++;
			imagesetpixel($im,$i,$j,$color);
			}
			if($k==1 && $i%2==1)
			{
			switch($x%6)
			{
			case 0:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 1:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			case 2:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 3:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 4:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 5:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			}
			imagesetpixel($im,$i,$j,$color);
			$x++;
			}
			
		}
	}
}
header("Content-Type: image/png");
imagepng($im);
?>