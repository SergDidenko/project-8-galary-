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

require 'field_template.php';

foreach ($indicators as $k=> $v) {
	if ($_SERVER['REQUEST_METHOD']==='POST') {
		
		if (isset($_FILES['upload'])) {
			$f=$_FILES['upload'];
			if ($f['error']===0) {
				$type=explode('/',$f['type'])[0];
				if ($type==$k) {
					$dir=$v['dir'];
					$index=$v['index'];
					$data_first=$v['data'][0];
					$new_path=tempnam($dir,$index);
					move_uploaded_file($f['tmp_name'],$new_path);
					$new_path=$dir.'/'.basename($new_path);
					require 'connection.php';
					mysqli_query($conn, "UPDATE $data_first SET name='{$f['name']}', path='{$new_path}' WHERE id={$id}");
				}
			}
			if (isset($_POST['tag'])) {
				require 'connection.php';
				$data_second=$indicators[$type]['data'][1];
				$data_third=$indicators[$type]['data'][2];
				mysqli_query($conn, "DELETE FROM $data_third WHERE type_id={$id};");
				$tag=explode(',',str_replace(" ","",$_POST['tag']));
				foreach ($tag as $val) {
					mysqli_query($conn, "INSERT INTO $data_second(tag) VALUES('{$val}') ON DUPLICATE KEY UPDATE tag='{$val}';");
					$tag_id=mysqli_insert_id($conn);
					if ($tag_id===0) {
						$tags=mysqli_query($conn, "SELECT * FROM $data_second");
						foreach ($tags as $v) {
							if ($val===$v['tag']) {
							$id_t=$v['id'];
							mysqli_query($conn, "INSERT INTO $data_third VALUES('{$id}', '{$id_t}');");
							break;
							}
						}
					}else{
						mysqli_query($conn, "INSERT INTO $data_third VALUES('{$id}', '{$tag_id}')");
					}
				}
				
			}
			header('Location:/upload.php?type='.$type);
				
		}
	}
}
if (isset($_GET['type'])) {
	$type=$_GET['type'];
}	
require 'header.php';
$tag_value='Update';
require 'upload_form.php';
require 'footer.php';