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
echo "</div>";
$image=$_SESSION['image'];
$parts=explode('.',$image);
$im=imagecreate(300,300);
if($parts[1]=='png')
$im=imagecreatefrompng('Images\\'.$image);
elseif($parts[1]=='jpg')
$im=imagecreatefromjpeg('Images\\'.$image);
elseif($parts[1]=='gif')
$im=imagecreatefromgif('Images\\'.$image);
else
{
echo 'no image file';
die();
}$text=$_SESSION['text'];
echo $text;
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
$k=rand(0,1);
$block=rand(10,20);
$keyrand=rand(0,1);
$color=imagecolorallocate($im,$block,$k,$keyrand);
imagesetpixel($im,0,1,$color);
$i=0;
$j=0;
$x=0;
$tm=0;
for($i=2;$i<imagesx($im);$i++)
{
	for($j=2;$j<imagesy($im);$j++)
	{	$color=0;
		$rgb=imagecolorat($im,$i,$j);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		if($block==$tm)
		{
		$tm=0;
		$block=rand(10,20);
		$keyrand=rand(0,1);
		$color=imagecolorallocate($im,$block,$g,$keyrand);
		imagesetpixel($im,$i,$j,$color);
		}
		else
		{
		if($x<$length)
		{	
			if($keyrand==1)
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
			$tm++;
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
			$tm++;
			}
			}
			if ($keyrand==0)
			{
			if($k==0 && $i%2==0)
			{
			switch($x%6)
			{
			case 0:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 1:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 2:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			case 3:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 4:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 5:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			}
			$x++;
			$tm++;
			imagesetpixel($im,$i,$j,$color);
			}
			if($k==1 && $i%2==1)
			{
			switch($x%6)
			{
			case 0:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 1:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 2:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			case 3:
			$color=imagecolorallocate($im,$r,ord($textarray[$x]),$b);
			break;
			case 4:
			$color=imagecolorallocate($im,ord($textarray[$x]),$g,$b);
			break;
			case 5:
			$color=imagecolorallocate($im,$r,$g,ord($textarray[$x]));
			break;
			}
			imagesetpixel($im,$i,$j,$color);
			$x++;
			$tm++;
			}
			
		}}
	}
}
}
imagepng($im,'Images\\'.$parts[0].'.png');
echo "
<h1>Encrypted Image is </h1>
<a  href='Images\\".$parts[0].".png' download='image' title='image' ><img src='Images/".$image."' height='300' width='290'/></a>
<div id='bottom'></div>
</div>
</body>
</html>";
?>