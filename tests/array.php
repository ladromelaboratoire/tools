<?php
require '../vendor/autoload.php';
use ladromelaboratoire\tools\arrays;
use ladromelaboratoire\tools\htmltools;


//Extrait de trace GPX
$points[] = array('lat' => 51.08252, 'long' => 2.52480, 'date' => '01/02/2021');
$points[] = array('lat' => 51.08263, 'long' => 2.52477, 'date' => '02/02/2021');
$points[] = array('lat' => 51.08288, 'long' => 2.52494, 'date' => '03/02/2021');
$points[] = array('lat' => 51.08922, 'long' => 2.54496, 'date' => '04/02/2021');
$points[] = array('lat' => 51.08917, 'long' => 2.54544, 'date' => '05/02/2021');
$points[] = array('lat' => 51.08888, 'long' => 2.54569, 'date' => '06/02/2021');
$points[] = array('lat' => 51.08886, 'long' => 2.54589, 'date' => '07/02/2021');
$points[] = array('lat' => 51.09220, 'long' => 2.55615, 'date' => '08/02/2021');
$points[] = array('lat' => 51.09391, 'long' => 2.56055, 'date' => '09/02/2021');
$points[] = array('lat' => 51.09438, 'long' => 2.56138, 'date' => '01/02/2021');
$points[] = array('lat' => 51.09585, 'long' => 2.56556, 'date' => '02/02/2021');
$points[] = array('lat' => 51.09564, 'long' => 2.56572, 'date' => '03/02/2021');
$points[] = array('lat' => 51.09475, 'long' => 2.56580, 'date' => '04/02/2021');
$points[] = array('lat' => 51.09346, 'long' => 2.56535, 'date' => '05/02/2021');
$points[] = array('lat' => 51.09229, 'long' => 2.56519, 'date' => '06/02/2021');
$points[] = array('lat' => 51.09221, 'long' => 2.56505, 'date' => '07/02/2021');
$points[] = array('lat' => 51.09193, 'long' => 2.56506, 'date' => '08/02/2021');
$points[] = array('lat' => 51.09179, 'long' => 2.56493, 'date' => '09/02/2021');
$points[] = array('lat' => 51.09160, 'long' => 2.56495, 'date' => '01/02/2021');
$points[] = array('lat' => 51.09126, 'long' => 2.56569, 'date' => '02/02/2021');
$points[] = array('lat' => 51.09124, 'long' => 2.56596, 'date' => '03/02/2021');
$points[] = array('lat' => 51.09131, 'long' => 2.56611, 'date' => '04/02/2021');
$points[] = array('lat' => 51.09142, 'long' => 2.56619, 'date' => '05/02/2021');
$points[] = array('lat' => 51.09160, 'long' => 2.56619, 'date' => '06/02/2021');
$points[] = array('lat' => 51.09219, 'long' => 2.56671, 'date' => '07/02/2021');
$points[] = array('lat' => 51.09246, 'long' => 2.56715, 'date' => '08/02/2021');
$points[] = array('lat' => 51.09254, 'long' => 2.56736, 'date' => '09/02/2021');
$points[] = array('lat' => 51.09248, 'long' => 2.56755, 'date' => '01/02/2021');
$points[] = array('lat' => 51.09226, 'long' => 2.56760, 'date' => '02/02/2021');
$points[] = array('lat' => 51.08990, 'long' => 2.56702, 'date' => '03/02/2021');



//tabeau trié ascendant
$tableau1 = arrays::array2DSort($points, 'lat', false);
//tableau trié descendant
$tableau2 = arrays::array2DSort($points, 'long', true);
//tableau trié par date ascendante
$tableau3 = arrays::array2DSortDate($points, 'date');


echo "<p>Données initiales <br/>";
echo htmltools::array2html($points, true);
echo "</p><p>tabeau trié ascendant <br/>";
echo htmltools::array2html($tableau1, true);
echo "</p><p>tableau trié descendant <br/>";
echo htmltools::array2html($tableau2, true);
echo "</p><p>tableau trié par date ascendante <br/>";
echo htmltools::array2html($tableau3, true);
echo "</p>";


?>