<div class="panel panel-warning">
	<div class="panel-heading">
		<h3 class="panel-title"><a href='#'>[Author : <?= $comment['user'] ?>]</a></h3>
	</div>
	<div class="panel-body">
		<?= $comment['comment'] ?>
		<?php if ($comment['user']===$_SESSION['user']) {?>
			<hr>	
			<a href='update_comment.php?id=<?= $comment['id'] ?>' class="btn btn-success">Update</a>
			<a href='delete_comment.php?id=<?= $comment['id'] ?>' class="btn btn-danger">Delete</a>
		<?php }?>
	</div>
	
	
</div>