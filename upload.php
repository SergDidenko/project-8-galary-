<?php 
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if (isset($_GET['type'])) {
	$type=$_GET['type'];
}
if (isset($_GET['max'])) {
	$max=$_GET['max'];
	setcookie('page',$max);
	header('Location:/');
}
$max=isset($_COOKIE['page']) ? $_COOKIE['page'] : 5;

$page=1;

if (isset($_GET['page'])) {
	$page=$_GET['page'];
}
$start=($page-1)*$max;
require "header.php";

require 'connection.php';
require 'field_template.php';

$data_first=$indicators[$type]['data'][0];
$files=mysqli_query($conn, "SELECT * FROM $data_first LIMIT $start, $max");

foreach ($files as $file){ 
	require 'result.php';	
}
if (!empty($file)) {
	require "pager.php";
}

require "footer.php";
