<?php
require '../vendor/autoload.php';
use ladromelaboratoire\tools\locations;

//La Drome laboratoire
$point1['lat'] = 44.90609;
$point1['long'] = 4.90495;
$point1['xl93'] = 850345.9;
$point1['yl93'] = 6424802.4;


//pointe de Corsen, Plouarzel, Finistère
$point2['lat'] = 48.41278;
$point2['long'] = -4.79556;

echo "Données de départ\r\n";
var_dump($point1);

$point1 = locations::lambert93ToWgs84($point1['xl93'], $point1['yl93']);
echo "conversion Lambert 93 vers WSG84\r\n";
var_dump($point1);

$point1 = locations::wsg84ToLambert93($point1['lat'], $point1['long']);
echo "conversion WSG84 vers Lambert93\r\n";
var_dump($point1);

$dist = locations::distance2Points($point1,$point2);
echo "Distance et azimut entre deux points<br/>Entre LDL et la pointe ouest de la Bretagne\r\n";
var_dump($dist);




?>