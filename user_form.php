<form action="" method="POST" class="form-horizontal" role="form">
		<div class="form-group">
			<legend class="user_form-title"><?= $user_val ?></legend>
		</div>
		<div class="form-group">
			<label for="inputUsername" class="col-sm-2 control-label">Username:</label>
			<div class="col-sm-10">
				<input type="text" name="username" id="inputUsername" class="form-control" value="" required="required" title="">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">Password:</label>
			<div class="col-sm-10">
				<input type="password" name="password" id="inputPassword" class="form-control" required="required" title="">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary"><?= $user_val ?></button>
			</div>
		</div>
</form>