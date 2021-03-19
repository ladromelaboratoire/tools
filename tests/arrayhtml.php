<?php
require '../vendor/autoload.php';
use ladromelaboratoire\tools\htmltools;

$data = [['Col1' => '1.1', 'Col2' => '1.2'],
		['Col1' => '2.1', 'Col2' => '2.2']];
	
echo "<p>";	
//This is an assoc array
echo htmltools::array2html($data, true);

echo "</p><p>";
//This is not an assoc array
echo htmltools::array2html($data, false);
echo "</p>";


?>