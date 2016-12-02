<?php 
session_start();
if (isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$user=null;
		$username=$_POST['username'];
		$password=$_POST['password'];
		require 'connection.php';
		$users=mysqli_query($conn, "SELECT * FROM users");
		foreach ($users as $val) {
			if ($username===$val['username']) {
				$user=$val;
				break;
			}
		}
		if ($user===null) {
			echo "User not valid";
		}else{
			if (password_verify($password, $user['pass'])) {
				$_SESSION['user']=$user['username'];
				header('Location:/');
			}else{
				echo "Password incorrect";
			}
		}
	}
}
require 'header.php';
$user_val='Login';
require 'user_form.php';
require 'footer.php';
