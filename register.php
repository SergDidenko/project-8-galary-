<?php 
session_start();
if (isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
	if (isset($_POST['username']) && isset($_POST['password'])){
		require "form_validation.php";
		if (preg_match($user_pattern,$_POST['username'])==true && preg_match($pass_pattern, $_POST['password'])==true) {
			$username=$_POST['username'];
			$password=password_hash($_POST['password'],1);
			require 'connection.php';
			mysqli_query($conn, "INSERT INTO users(username, pass) VALUES('{$username}', '{$password}');");
			header('Location:/');
		}
		if(preg_match($user_pattern,$_POST['username'])==false){
			echo ' Incorrect name for user ';
		}
		if(preg_match($pass_pattern, $_POST['password'])==false) {
			echo ' Incorrect password for user ';
		}
	}
}

require 'header.php';
$user_val='Register';
require 'user_form.php';
require 'footer.php';
