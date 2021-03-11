<?php
require '../vendor/autoload.php';
use ladromelaboratoire\tools\arrays;

$array = array(
	array('date' => '20/12/2020', 'valeur' => 2, 'nom' => 'toto'),
	array('date' => '15/12/2020', 'valeur' => 3, 'nom' => 'titi'),
	array('date' => '15/12/2021', 'valeur' => 4, 'nom' => 'tutu'),
	array('date' => '15/01/2019', 'valeur' => 5, 'nom' => 'tete'),
);

var_dump(arrays::array2DSortDate($array, 'date'));


?>