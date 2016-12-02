<?php 
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
}else{
	$user=$_SESSION['user'];
}
require 'connection.php';
require 'field_template.php';

foreach ($indicators as $k=> $v) {
	if ($_SERVER['REQUEST_METHOD']==='POST') {
		if (isset($_FILES['upload']) && isset($_POST['tag'])) {
			$f=$_FILES['upload'];
			$type=explode('/',$f['type'])[0];
			if ($type==$k) {
				if ($f['error']===0) {
					
					$dir=$v['dir'];
					$index=$v['index'];
					$data_first=$v['data'][0];
					$new_path=tempnam($dir, $index);
					move_uploaded_file($f['tmp_name'],$new_path);
					$new_path=$dir.'/'.basename($new_path);
					mysqli_query($conn, "INSERT INTO $data_first(name, type, path, user) VALUES('{$f['name']}', '{$type}','{$new_path}','{$user}');");

					$type_id=mysqli_insert_id($conn);
						
				}

			// checking of tag part

				$tag=explode(',',str_replace(" ", "", $_POST['tag']));
				foreach ($tag as $val) {
					
					$data_second=$indicators[$type]['data'][1];
					$data_third=$indicators[$type]['data'][2];

					//on duplicate key update

					mysqli_query($conn, "INSERT INTO $data_second(tag) VALUES('{$val}') ON DUPLICATE KEY UPDATE tag='{$val}'; ");
						$tag_id=mysqli_insert_id($conn);
						if ($tag_id!==0) {
							mysqli_query($conn, "INSERT INTO $data_third VALUES('{$type_id}', '{$tag_id}')");
						}else{
							$tags=mysqli_query($conn, "SELECT * FROM {$data_second};");
							foreach ($tags as $v) {
								if ($val===$v['tag']) {
								$id=$v['id'];
								mysqli_query($conn, "INSERT INTO $data_third VALUES('{$type_id}', '{$id}')");
							}
						}
					}
				}
			header('Location:/upload.php?type='.$type);
			exit();
			}
		}	
	}
}


require 'header.php';
$tag_value='Upload';
require 'upload_form.php';
require 'footer.php';