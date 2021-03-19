<?php

/*********
*
*  File: arrays.php
*  Date: 18/03/2021
*  Suject : advanced fucntion to work on arrays
*
**********/

namespace ladromelaboratoire\tools;
use DateTime;

class arrays {
	
	public static function array2DSort($records, $field, $reverse=false) {
		$hash = array();
	   
		foreach($records as $record) {
			//Tri problématique quand nous sommes face à des nombres. Conversion en chaine, puis ajout d'une chaine aléatoire pour ne pas écraser les lignes.
			$hash[(string)$record[$field].sprintf("%'.09d\n", rand(1, 999999999))] = $record;
		}
	   
		($reverse)? krsort($hash) : ksort($hash);
	   
		$records = array();
	   
		foreach($hash as $record) {
			$records []= $record;
		}
	   
		return $records;
	}
	
	public static function array2DSortDate($records, $field, $format_in = 'd/m/Y', $reverse=false) {
		$hash = array();
	   
		foreach($records as $record) {			
			//Cette méthode présente le bug d'écraser les lignes du tableau qui présentent la même date. Car le timestamp retourné correspond à 0h00
			//le nombre aléatoire a été ajouté pour que les timestanps ne s'écrasent pas en restant dans la même journée.
			//Cela donne une amplitude aléatoire de 0h00:02 à 23h59:58
			//Ne fonctionnera pas si la date analysée comporte un horaire
			$hash[DateTime::createFromFormat($format_in, $record[$field])->getTimestamp()+rand(2, 86398)] = $record;
		}
	   
		($reverse)? krsort($hash) : ksort($hash);
	   
		$records = array();
	   
		foreach($hash as $record) {
			$records []= $record;
		}
	   
		return $records;
	}
}

?>