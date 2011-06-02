<?php
//http://134.178.153.37/5840/5840.php?region=Murry-Darling%20Basin&precipDecile=100&precipAmtMm=554&etDecile=40&etAmtMm=457&wsChangePc=10mtMm=457&wsChangePc=10

$image = imagecreatefromjpeg("5840.jpg");

//colours
$blue = imagecolorallocate($image,47,92,124);
$black = imagecolorallocate($image, 0,0,0);
$white = imagecolorallocate($image, 255,255,255);

//fonts
$helv = '../fonts/HelveticaNeue.ttf';
$helvLight = '../fonts/HelveticaNeueLight.ttf';
$arialBd = '../fonts/arialbd.ttf';

$titleFontSize = 24;
$regionFontSize = 20;
$nameFontSize = 18;
$valueFontSize = 18;

//title
$title = "Estimated landscape water
flows and stores 2009-10";
ImageTTFText ($image, $titleFontSize, 0, 1128, 53, $blue, $helvLight,$title);

//Region Title
$region = htmlspecialchars($_GET["region"]);
$bbArray = imagettfbbox($regionFontSize, 0, $arialBd, $region);
$textLength = $bbArray[2] - $bbArray[0]; 
ImageTTFText ($image, $regionFontSize, 0, 1495-$textLength, 118, $blue, $arialBd,$region);

//circles

$decile_100 = imagecolorallocate($image, 101,101,254);
$decile_80 = imagecolorallocate($image, 203,203,254);
$decile_40 = imagecolorallocate($image, 255,255,255);
$decile_20 = imagecolorallocate($image, 254,203,203);
$decile_1 = imagecolorallocate($image, 254,101,101);
$stroke = imagecolorallocate($image, 80,80,80);
$decCircRadius = 45;

// Precipitation
$precipDecile= htmlspecialchars($_GET["precipDecile"]);
$precipAmtMm= htmlspecialchars($_GET["precipAmtMm"]);

switch ($precipDecile) {
	case 100: $colour = $decile_100; break;
	case 80: $colour= $decile_80; break;
	case 40: $colour= $decile_40; break;
	case 20: $colour= $decile_20; break;
	case 10: $colour= $decile_1; break;
	default: $colour= $black; break;
}

imagefilledellipse($image, 295, 60, $decCircRadius, $decCircRadius, $stroke);
imagefilledellipse($image,295,60,$decCircRadius-3,$decCircRadius-3,$colour);
ImageTTFText ($image, $nameFontSize, 0, 328, 68, $blue, $arialBd,'Rainfall');
ImageTTFText ($image, $valueFontSize, 0, 328, 95, $blue, $helv,"$precipAmtMm mm");

// Evapotranspiration
$etDecile= htmlspecialchars($_GET["etDecile"]);
$etAmtMm= htmlspecialchars($_GET["etAmtMm"]);

switch ($etDecile) {
	case 100: $colour= $decile_100; break;
	case 80: $colour= $decile_80; break;
	case 40: $colour= $decile_40; break;
	case 20: $colour= $decile_20; break;
	case 10: $colour= $decile_1; break;
	default: $colour= $black; break;
}

imagefilledellipse($image, 730, 60, $decCircRadius, $decCircRadius, $stroke);
imagefilledellipse($image,730,60,$decCircRadius-3,$decCircRadius-3,$colour);
ImageTTFText ($image, $nameFontSize, 0, 480, 68, $blue, $arialBd,'Evapotranspiration');
ImageTTFText ($image, $valueFontSize, 0, 480, 95, $blue, $helv,"$etAmtMm mm");

// Water Storage
$wsChangePc= htmlspecialchars($_GET["wsChangePc"]);
$plus = "";
if ($wsChangePc > 0) { $plus = "+";}
$x = 710;
$y = 260;
ImageTTFText ($image, $nameFontSize, 0, $x, $y, $white, $arialBd,'Water Storage');
ImageTTFText ($image, $valueFontSize, 0, $x, $y+28, $white, $helv,"$plus$wsChangePc%");

// Landscape Water Yield
$lwDecile= htmlspecialchars($_GET["lwDecile"]);
$lwAmtMm= htmlspecialchars($_GET["lwAmtMm"]);

switch ($lwDecile) {
	case 100: $colour= $decile_100; break;
	case 80: $colour= $decile_80; break;
	case 40: $colour= $decile_40; break;
	case 20: $colour= $decile_20; break;
	case 10: $colour= $decile_1; break;
	default: $colour= $black; break;
}

$y = 450;

imagefilledellipse($image, 1000, $y, $decCircRadius, $decCircRadius, $stroke);
imagefilledellipse($image,1000,$y,$decCircRadius-3,$decCircRadius-3,$colour);
ImageTTFText ($image, $nameFontSize, 0, 1030, $y+9, $white, $arialBd,'Landscape Water Yield');
ImageTTFText ($image, $valueFontSize, 0, 1030, $y+37, $white, $helv,"$lwAmtMm mm");

// Soil Moisture
$smChangePc= htmlspecialchars($_GET["smChangePc"]);
$plus = "";
$x = 565;
$y = 730;
if ($smChangePc > 0) { $plus = "+";}
ImageTTFText ($image, $nameFontSize, 0, $x, $y, $white, $arialBd,'Soil Moisture');
ImageTTFText ($image, $valueFontSize, 0, $x+100, $y+28, $white, $helv,"$plus$smChangePc%");


//image draw
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);

?>
