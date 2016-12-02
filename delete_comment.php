<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
	exit();
}
$id=isset($_GET['id']) ? $_GET['id'] : null;

require 'connection.php';
mysqli_query($conn, "DELETE FROM comments WHERE id={$id}");
header('Location:/');
exit();