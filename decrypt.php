<?php
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
echo "
<body>
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<h1>Stegany</h1>
<h6>A pure php steganography implementation</h6>
<div id='left-nav'>";
include("left-nav.php");
include('Crypt/AES.php');
   $aes = new Crypt_AES();
   $aes->setKey('abcdefghijklmnop');
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
        sprintf('./Cryptimages/%s.%s',
            sha1_file($_FILES['userfile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
	

} catch (RuntimeException $e) {

    echo $e->getMessage();

}
$im=imagecreatefrompng('Cryptimages\\'.$test);
$rgb=imagecolorat($im,0,0);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$length=$g;
$pon=0;
$block=0;
$keyrand=0;
$rgb=imagecolorat($im,0,1);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
$k=$g;
$block=$r;
$keyrand=$b;
$i=0;
$j=0;
$x=0;
$tm=0;
$text=array();
for($i=2;$i<imagesx($im);$i++)
{
	for($j=2;$j<imagesy($im);$j++)
	{
		$rgb=imagecolorat($im,$i,$j);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		if($block==$tm)
		{
			$pon+=1;
			$block=$r;
			$keyrand=$b;
			$tm=0;
		}
		else{
		if($x<$length)
		{	
			if($keyrand==1)
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
			$tm++;
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
			$tm++;
			}
			}
			if($keyrand==0)
			{
				if($k==0 && $i%2==0)
			{
			switch($x%6)
			{
			case 0:
			array_push($text,chr($g));
			break;
			case 1:
			array_push($text,chr($r));
			break;
			case 2:
			array_push($text,chr($b));
			break;
			case 3:
			array_push($text,chr($g));
			break;
			case 4:
			array_push($text,chr($r));
			break;
			case 5:
			array_push($text,chr($b));
			break;
			}
			$x++;
			$tm++;
			}
			if($k==1 && $i%2==1)
			{
			switch($x%6)
			{
			case 0:
			array_push($text,chr($g));
			break;
			case 1:
			array_push($text,chr($r));
			break;
			case 2:
			array_push($text,chr($b));
			break;
			case 3:
			array_push($text,chr($g));
			break;
			case 4:
			array_push($text,chr($r));
			break;
			case 5:
			array_push($text,chr($b));
			break;
			}
			$x++;
			$tm++;
			}
			}
		}
	}}
}
echo '</div>';
$plaintext=$aes->decrypt(implode($text));
echo '<h1>Decrypted text is: '.$plaintext.'</h1>';
echo '
<div id="bottom"></div>
</div>
</body>
</html>';
?>