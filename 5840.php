<?php
//http://134.178.153.37/5840/5840.php?region=EnterRegionHere&precipDecile=100&precipAmtMm=554&etDecile=20&etAmtMm=457

$image = imagecreatefromjpeg("5840.jpg");

//colours
$blue = imagecolorallocate($image,47,92,124);
$black = imagecolorallocate($image, 0,0,0);
$white = imagecolorallocate($image, 255,255,255);

//fonts
$helvLight = 'fonts/HelveticaNeueLight.ttf';
$arialBd = 'fonts/arialbd.ttf';

$titleFontSize = 24;
$regionFontSize = 20;
$nameFontSize = 17;
$valueFontSize = 17;

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
	case 100: $precipColour = $decile_100; break;
	case 80: $precipColour = $decile_80; break;
	case 40: $precipColour = $decile_40; break;
	case 20: $precipColour = $decile_20; break;
	case 1: $precipColour = $decile_1; break;
}

imagefilledellipse($image, 295, 60, $decCircRadius, $decCircRadius, $stroke);
imagefilledellipse($image,295,60,$decCircRadius-3,$decCircRadius-3,$precipColour);
ImageTTFText ($image, $nameFontSize, 0, 328, 68, $blue, $arialBd,'Rainfall');
ImageTTFText ($image, $valueFontSize, 0, 328, 95, $blue, $helvLight,"$precipAmtMm mm");

// Evapotranspiration
$etDecile= htmlspecialchars($_GET["etDecile"]);
$etAmtMm= htmlspecialchars($_GET["etAmtMm"]);

switch ($etDecile) {
	case 100: $etColour = $decile_100; break;
	case 80: $etColour = $decile_80; break;
	case 40: $etColour = $decile_40; break;
	case 20: $etColour = $decile_20; break;
	case 1: $etColour = $decile_1; break;
}

imagefilledellipse($image, 720, 60, $decCircRadius, $decCircRadius, $stroke);
imagefilledellipse($image,720,60,$decCircRadius-3,$decCircRadius-3,$etColour);
ImageTTFText ($image, $nameFontSize, 0, 480, 68, $blue, $arialBd,'Evapotranspiration');
ImageTTFText ($image, $valueFontSize, 0, 480, 95, $blue, $helvLight,"$precipAmtMm mm");


//image draw
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);

?>
