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
}
require 'connection.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
	if (isset($_POST['comment'])) {
		$comment=htmlentities($_POST['comment']);
		$user=$_SESSION['user'];
		mysqli_query($conn, "INSERT INTO comments(comment, user, type, type_id) VALUES('{$comment}', '{$user}','{$type}', '{$id}');");
	}
}
require 'field_template.php';
$data_first=$indicators[$type]['data'][0];
$files=mysqli_query($conn, "SELECT * FROM $data_first WHERE id={$id}");


require 'header.php';
foreach ($files as $file) {
	require "result.php";
}
$comments=mysqli_query($conn, "SELECT * FROM comments WHERE type_id={$id} AND type='{$type}'");
foreach ($comments as $comment) {
	require 'comment_result.php';
}
$title="Comment";
require "comment_form.php";
require 'footer.php';