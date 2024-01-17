<?php
require '../vendor/autoload.php';
use ladromelaboratoire\tools\locations;

//Appel alternatif de la classe - sans composer
// require('chemin/vers/la/classe/locations.php');

//La Drome laboratoire
$point1['lat'] = 44.90609;
$point1['long'] = 4.90495;
$point1['xl93'] = 850345.9;
$point1['yl93'] = 6424802.4;


//pointe de Corsen, Plouarzel, Finistère
$point2['lat'] = 48.41278;
$point2['long'] = -4.79556;

//drome
$point3['lat'] = 44.709999;
$point3['long'] = 5.079999;

//antenne
$point4['lat'] = 44.7656379;
$point4['long'] = 5.1077537;

echo "Données de départ\r\n";
var_dump($point1);

$point1 = locations::lambert93ToWgs84($point1['xl93'], $point1['yl93']);
echo "conversion Lambert 93 vers WSG84\r\n";
var_dump($point1);

$point1 = locations::wgs84ToLambert93($point1['lat'], $point1['long']);
echo "conversion WSG84 vers Lambert93\r\n";
var_dump($point1);

$dist = locations::distance2Points($point3,$point4);
echo "Distance et azimut entre deux points<br/>Entre LDL et la pointe ouest de la Bretagne\r\n";
var_dump($dist);

?>
