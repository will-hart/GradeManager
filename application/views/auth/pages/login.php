
<?php 
	$img['src'] = 'assets/images/gm_large_logo.png';
	$img['alt'] = "Grade Boss Logo";
	$img['height'] = '332';
	$img['width'] = '335';
	$img['class'] = 'large_login_logo';
	echo img($img);
?>
	<div style="padding-top:30px;">
		<form method="POST">
			Username/Email:<br />
			<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" /><?php echo form_error('username', '<div class="error">','</div>'); ?><br /><br />
			Password:<br />
			<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" /><?php echo form_error('password', '<div class="error">', '</div>'); ?><br /><br />
			<input type="submit" value="Login" name="login" /> <br>
			or <?php echo anchor('register','Register'); ?> <br>
			or <?php echo anchor('manage/forgot_password','Did you forget your password?');?>
		</form>
		
	</div>
