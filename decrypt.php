<?php
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
$rgb=imagecolorat($im,0,0);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$length=$g;
echo $length.'</br>';
$rgb=imagecolorat($im,0,1);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$k=$g;
echo 'k is '.$k.'</br>';
$i=0;
$j=0;
$x=0;
$text=array();
for($i=2;$i<imagesx($im);$i++)
{
	for($j=2;$j<imagesy($im);$j++)
	{
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
			array_push($text,chr($r));
			break;
			case 1:
			array_push($text,chr($b));
			break;
			case 2:
			array_push($text,chr($g));
			break;
			case 3:
			array_push($text,chr($r));
			break;
			case 4:
			array_push($text,chr($g));
			break;
			case 5:
			array_push($text,chr($b));
			break;
			}
			$x++;
			}
			if($k==1 && $i%2==1)
			{
			switch($x%6)
			{
			case 0:
			array_push($text,chr($r));
			break;
			case 1:
			array_push($text,chr($b));
			break;
			case 2:
			array_push($text,chr($g));
			break;
			case 3:
			array_push($text,chr($r));
			break;
			case 4:
			array_push($text,chr($g));
			break;
			case 5:
			array_push($text,chr($b));
			break;
			}
			$x++;
			}
			
		}
	}
}
echo implode($text);
?>