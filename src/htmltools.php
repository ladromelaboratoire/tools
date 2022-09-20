<?php

/*********
*
*  File: htmltools.php
*  Date: 01/03/2021
*  Suject : set of static methods to transform data to html entities
*
**********/

namespace ladromelaboratoire\tools;

class htmltools {
	
	public static function array2html($arraydata, $is_assoc = false) {
		//$thead = array_shift(self::$arraydata);
		if ($is_assoc) {
			$thead = "<tr><th>" . implode("</th><th>", array_keys($arraydata[0])) . "</th></tr>\r\n";
		}
		else {
			$thead = "<tr><th>" . implode("</th><th>", array_shift($arraydata)) . "</th></tr>\r\n";
		}
		$tbody = "";
		foreach ($arraydata as $row) {
			$tbody .= "<tr><td>".implode("</td><td>",$row)."</td></tr>\r\n";
		}
		
		return "<table>\r\n<thead>".$thead."</thead><tbody>".$tbody."</tbody></table>";
	}

	public static function fillHtmlTemplate ($patterns, $replacements, $template) {
		if (is_file($template)) {
			return preg_replace($patterns, $replacements, file_get_contents($template));
		}
		else {
			return false;
		}
	}
	
}

?>