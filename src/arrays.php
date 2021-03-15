<?php

/*********
*
*  File: arrays.php
*  Date: 01/03/2021
*  Suject : advanced fucntion to work on arrays
*
**********/

namespace ladromelaboratoire\tools;
use DateTime;

class arrays {
	
	public static function array2DSort($records, $field, $reverse=false) {
		$hash = array();
	   
		foreach($records as $record) {
			$hash[$record[$field]] = $record;
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
			//le nombre aléatoire a été ajouté pour que les timestanps ne s'écrasent pas en restant dans la même journée.
			$hash[DateTime::createFromFormat($format_in, $record[$field])->getTimestamp()+rand(10, 86390)] = $record;
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