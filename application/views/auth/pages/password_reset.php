<div id="login">
	<?php 
		$img['src'] = 'assets/images/gm_large_logo.png';
		$img['alt'] = "Grade Boss Logo";
		$img['height'] = '332';
		$img['width'] = '335';
		$img['class'] = 'large_login_logo';
		echo img($img);
	?>

	<form method="post">
		<p>
			Enter your new new password below:
		</p>
	
	Password:<br />
	<input type="password" name="password" size="50" class="form" value="<?php echo set_value('password'); ?>" /><?php echo form_error('password', '<div class="error">','</div>'); ?><br /><br />
	Password confirmation:<br />
	<input type="password" name="password_conf" size="50" class="form" value="<?php echo set_value('conf_password'); ?>" /><?php echo form_error('conf_password', '<div class="error">','</div>'); ?><br /><br />
	<input type="submit" value="Change Password" name="change" />
	</form>
</div>
