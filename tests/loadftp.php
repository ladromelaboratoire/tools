<?php

require '../vendor/autoload.php';
use ladromelaboratoire\tools\loadftp;

$server = 'localhost';
$login = 'admin';
$pwd = 'admin';
$folder = "./sampledata/";
// $filter = "*.csv";
$filter = "*";
$files = glob($folder.$filter);

if (is_array($files)) {

	$job = new loadftp($server, $login, $pwd);
	$job->connectftp();
	$result = $job->load($files);
	$job->disconnect();
	unset($job);

	var_dump($result);
}


?>