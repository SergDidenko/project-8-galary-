<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if (isset($_GET['id'])) {
	$id=$_GET['id'];
}else{
	header('Location:/');
	exit();
}
require "connection.php";
if ($_SERVER['REQUEST_METHOD']==='POST') {
	if (isset($_POST['comment'])) {
		$com=$_POST['comment'];
		$user=$_SESSION['user'];
		$comments=mysqli_query($conn, "SELECT * FROM comments WHERE id={$id};");
		foreach ($comments as $comment) {
			if ($com!==$comment['comment'] && $user===$comment['user']) {
				mysqli_query($conn, "UPDATE comments SET comment='{$com}' WHERE id={$id}");
				header('Location:/separate.php?type='.$comment['type'].'&id='.$comment['type_id']);
				exit();
			}
		header('Location:/separate.php?type='.$comment['type'].'&id='.$comment['type_id']);
		exit();
		}
	}
}

require "header.php";
$comments=mysqli_query($conn, "SELECT * FROM comments WHERE id={$id}");
foreach ($comments as $comment) {
	$title="Update";
	require "comment_result.php";
	require "comment_form.php";
}
require "footer.php";
