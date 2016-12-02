<?php 
session_start();
if (!isset($_SESSION['user'])) {
	header('Location:/');
}else{
	$user=$_SESSION['user'];
}
if ($_SERVER['REQUEST_METHOD']==='POST') {
	if (isset($_FILES['upload']) && isset($_POST['tag'])) {
		$f=$_FILES['upload'];
		if ($f['error']===0) {
			$new_path=tempnam('uploads', 'img');
			move_uploaded_file($f['tmp_name'],$new_path);
			$new_path='uploads/'.basename($new_path);
			$type=explode('/',$f['type'])[0];
			require 'connection.php';
			mysqli_query($conn, "INSERT INTO images(name, type, path,user) VALUES('{$f['name']}', '{$type}','{$new_path}','{$user}');");
			$image_id=mysqli_insert_id($conn);
		}

		// checking of tag part

		$tag=explode(',',$_POST['tag']);
		foreach ($tag as $val) {
			//on duplicate key update
			mysqli_query($conn, "INSERT INTO tags (tag) VALUES('{$val}') ON DUPLICATE KEY UPDATE tag='{$val}';");
				$tag_id=mysqli_insert_id($conn);
				if ($tag_id!==0) {
					mysqli_query($conn, "INSERT INTO images_tags VALUES('{$image_id}', '{$tag_id}')");
				}else{
					$tags=mysqli_query($conn, "SELECT * FROM tags");
					foreach ($tags as $v) {
						if ($val===$v['tag']) {
						$id=$v['id'];
						mysqli_query($conn, "INSERT INTO images_tags VALUES('{$image_id}', '{$id}')");
					}
				}
			}
		}
		header('Location:/picture_upload.php');
		exit();
	}	
}


require 'header.php';
$tag_value='Upload';
require 'upload_form.php';
require 'footer.php';