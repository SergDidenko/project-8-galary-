<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><a href="/separate.php?type=<?= $file['type'] ?>&id=<?= $file['id'] ?>">Details... </a>[Author : <?= $file['user'] ?>]</h3>
	</div>
	<div class="panel-body">
		<div class='upload-file_picture'>
			<?php 
			switch ($file['type']) {
				case 'image':
					echo '<img src="'.$file['path'].'" width=200px height=200px>';
					break;
				case 'audio':
					echo '<span>'.$file['name'].'</span><br>';
					echo '<audio src="'.$file['path'].'" controls></audio>';
					break;
				case 'video':
					echo '<span>'.$file['name'].'</span><br>';
					echo '<video src="'.$file['path'].'" controls="controls"></video>';
					break;
			}?>
			
		</div>
		<div class='upload-file_tag'>
			<?php 
				require 'connection.php';
				require 'field_template.php';
				$data_second=$indicators[$type]['data'][1];
				$data_third=$indicators[$type]['data'][2];
				$tags=mysqli_query($conn, "SELECT t.id,t.tag FROM $data_second AS t JOIN $data_third ON t.id=tag_id AND 
					{$file['id']}=type_id");
				foreach ($tags as $tag) {
					echo '<a class="upload-file_link" href="/tag.php?tag='.$tag['id'].'&type='.$file['type'].'">[ '.$tag['tag'].' ]</a>';
				}
			?>
			
		</div>
		<div>
		</div>
	
	
	<?php if ($_SESSION['user']===$file['user']) {?>
	<hr>	
	
	<a href="/update.php?type=<?= $file['type'] ?>&id=<?= $file['id'] ?>" class="btn btn-success">Update</a>
	<a class="btn btn-danger" data-toggle="modal" href='#modal-id-<?= $file['id']?>'>Delete</a>
	<div class="modal fade" id="modal-id-<?= $file['id'] ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Are you sure?</h4>
				</div>
				<div class="modal-body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<a href="/delete.php?type=<?= $file['type'] ?>&id=<?= $file['id'] ?>" class="btn btn-danger">Delete</a>	
				</div>
			</div>
		</div>
		</div>
		<?php } ?>
	</div>
</div>
