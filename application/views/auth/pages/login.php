<div id="login">
	
	<h2>Login</h2>
	<div class="box">
			<form method="POST">
			Username/Email:<br />
			<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" class="form" /><?php echo form_error('username', '<div class="error">','</div>'); ?><br /><br />
			Password:<br />
			<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" class="form" /><?php echo form_error('password', '<div class="error">', '</div>'); ?><br /><br />
			<input type="submit" value="Login" name="login" />
			</form>
	</div>
</div>
