<?php

/*********
*  File: htmltools.php
*  Date: 01/03/2021
*  Suject : set of static methods to transform data to html entities
*
**********/

namespace ladromelaboratoire\tools;

class htmltools {
	
	static $arraydata ;
	
	public static function array2html() {
		//$thead = array_shift(self::$arraydata);
		$tbody = array_reduce(self::$arraydata, 'self::reducearray');
		$thead = "<tr><th>" . implode("</th><th>", array_keys(self::$arraydata[0])) . "</th></tr>";
		return "<table>".$thead.$tbody."</table>\r\n";
	}
	protected static function reducearray($a,$b) {
		if (is_array($b)) {
			return $a.="<tr><td>".implode("</td><td>",$b)."</td></tr>\r\n";
		}
		else {
			return $a.="<tr><td>".$b."</td></tr>";
		}
	}
	
}

?>