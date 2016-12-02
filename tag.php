<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if (isset($_GET['tag']) && isset($_GET['type'])) {
	$tag=$_GET['tag'];
	$type=$_GET['type'];
}
require 'connection.php';
require 'field_template.php';
$data_first=$indicators[$type]['data'][0];
$data_second=$indicators[$type]['data'][1];
$data_third=$indicators[$type]['data'][2];
$files=mysqli_query($conn, "SELECT f.id, f.name, f.type, f.path, f.user FROM $data_first  AS f JOIN $data_third JOIN $data_second AS t ON f.id=type_id AND t.id=tag_id AND tag_id={$tag};");
require 'header.php';
foreach ($files as $file){ 
	require 'result.php';	
}
require 'footer.php';