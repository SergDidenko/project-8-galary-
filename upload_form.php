<form action="" method="POST" class="form-horizontal" role="form" enctype='multipart/form-data'>
		<div class="form-group">
			<label for="inputTag" class="col-sm-2 control-label">Tag:</label>
			<div class="col-sm-10">
				<input type="text" name="tag" id="inputTag" class="form-control" value="<?php
					if ($tag_value==='Update') {
						require 'connection.php';
						require 'field_template.php';
						$data_second=$indicators[$type]['data'][1];
						$data_third=$indicators[$type]['data'][2];
						$tags=mysqli_query($conn, "SELECT t.id, t.tag  FROM $data_second as t JOIN $data_third ON type_id={$id} AND t.id=tag_id;");
						foreach ($tags as $v) {
							echo $v['tag'].",";
						}
					}?>" required="required"  title="">
			</div>
		</div>
		
		<div class="fileform ">
			<div class="selectbutton">Choose</div>
			<input id="upload" type="file" name="upload" />
		</div>
		
		<div class="form-group form-line">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary"><?=$tag_value?></button>
			</div>
		</div>
</form>