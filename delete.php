<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if (isset($_GET['type'])) {
	$type=$_GET['type'];
}
if (isset($_GET['id'])) {
	$id=$_GET['id'];
}else{
	header('Location:/');
	exit();
}
require 'connection.php';
require 'field_template.php';
$data_first=$indicators[$type]['data'][0];
mysqli_query($conn, "DELETE FROM $data_first WHERE id={$id};");
header('Location:/upload.php?type='.$type);