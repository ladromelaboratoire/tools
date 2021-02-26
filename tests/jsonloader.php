<?php

require '../vendor/autoload.php';
use ladromelaboratoire\tools\jsonLoader;

$file = "sample.json";
$tableau = new jsonLoader($file);

// Altenative call
// $tableau = new jsonLoader();
// $tableau->jsonGrabber($file);

echo "<pre>";
if($tableau->error) {
	echo $tableau->error_message;
}
else {
	print_r($tableau->jsonArray);
}
echo "</pre>";
?>